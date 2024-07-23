<?php

namespace App\Http\Controllers\Cms;

use App\Clients;
use App\Traits\SlugTrait;
use App\Helpers\CmsHelper;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Cms\RestrictedController;
use App\InformationClient;

class InformationClientController extends RestrictedController
{

    use UploadTrait;
    Use SlugTrait;
    public function index(Request $request, $id)
    {
        $data = $request->all();
        #PAGE TITLE E BREADCRUMBS
        $clients = Clients::find($id);
        $headers = parent::headers(
            "Sobre o Cliente",
            [
                [
                    "icon" => "",
                    "title" => "Clientes",
                    "url" => "",
                ],
            ]
        );
        #LISTA DE ITENS
        $titles = json_encode(["#", "Titulo", "Descricão"]);
        $actions = json_encode([
            [
                'path' => '{item}/edit',
                'icon' => 'fa fa-pencil',
                'label' => 'Perfil',
                'color' => 'primary',
            ],
        ]);

        $busca = '';
        $pagination = 15;
        if (!empty($data['busca'])) {
            if ($data['busca'] != null && $data['busca'] != '') {
                $busca = $data['busca'];
            }
            $pagination = 500;
        }
        $items = InformationClient::select('id', 'title', 'description')->where('client_id', $id)
            ->where(function ($query) use ($data) {
                if (!empty($data['busca'])) {
                    $query->where('name', 'LIKE', "%" . $data['busca'] . "%");
                }
            })->orWhere(function ($query) use ($data) {
                if (!empty($data['busca'])) {
                    $query->where('id', $data['busca']);
                }
            })->orderBy('id', 'asc')
            ->paginate($pagination);

            /* dd($clients); */


        return view('cms.clients.informations.index', compact('headers', 'titles', 'items', 'busca', 'actions', 'clients'));
    }

    private function calcDate($billing_day, $number_of_months)
    {
        // Inicializar as datas no formato correto
        $data = [
            'billing_day' => null,
            'number_of_months' => null,
        ];

        // Calcular a próxima data de vencimento baseada no dia de faturamento
        $nextBillingDate = now()->startOfMonth()->setDay($billing_day);
        $data['billing_day'] = $nextBillingDate->format('Y-m-d');

        // Verificar se a próxima data de vencimento é anterior à data atual
        if ($nextBillingDate->format('d') < date('d')) {
            $nextBillingDate = now()->addMonth()->startOfMonth()->setDay($billing_day);
            $data['billing_day'] = $nextBillingDate->format('Y-m-d');
        }
        // Calcular a proxima data de vencimento
        $nextDueDate = $nextBillingDate->addMonths($number_of_months);

        // Formatar a data
        $data['number_of_months'] = $nextDueDate->format('Y-m-d');


        return $data;
    }
    public function store(Request $request, $contract_id)
    {
        $data = $request->all();
/*         $validator = $this->validation($data);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
 */

        $data['client_id'] = $contract_id;
        InformationClient::create($data);
        
        return redirect()->back()->with('message', 'Registro cadastrado com sucesso!');
    }

    public function update(Request $request, $contract_id, $id)
    {
        $data = $request->all();

        $validation = $this->validation($data);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }


        if ($data['type'] == 'adendo') {
            $data['description'] = $data['description_adendo'];
        } else {
            $data['description'] = $data['description_linha'];
        }
        $contract = ItensContract::where('id', $id)->first();
        $contract->update($data);

        return redirect()->route('contracts.itens.index', $contract_id)->with('message', 'Registro atualizado com sucesso!');
    }
    public function show($id, $doc_id)
    {
        $document = FileContract::find($doc_id);
        if ($document && !empty($document->attachment)) {
            $filePath = storage_path('app/public/' . $document->attachment);
            if (file_exists($filePath)) {
                return response()->file($filePath);
            } else {
                return redirect()->back()->with('error', 'Arquivo PDF não encontrado.');
            }
        } else {
            return redirect()->back()->with('error', 'Arquivo PDF não encontrado.');
        }
    }

    public function edit($id_product, $item_doc)
    {

        #PAGE TITLE E BREADCRUMBS
        $headers = parent::headers(
            "Itens do Contrato",
            [
                ["icon" => "", "title" => "Itens", "url" => route('contracts.itens.index', [$id_product, $item_doc])],
                ["icon" => "", "title" => "Editar", "url" => ""],
            ]
        );

        /*  dd($id_product, $item_doc); */
        $plans = Plan::all();
        $item = ItensContract::where('id', $item_doc)->first();

        if (empty($item)) {
            return redirect()->back();
        }
        $sellers = Group::all();
        return view('cms.contracts.itens.edit', compact('headers', 'sellers', 'item', 'id_product', 'plans'));
    }

    public function destroy(Request $request)
    {
        $data = $request->all();

        if (isset($data['registro'])) {
            $docs = InformationClient::whereIn('id', $data['registro'])->get();
            foreach ($docs as $doc) {
                if (!empty($doc->file)) {
                    $filePath = storage_path('app/public/' . $doc->file);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    } else {
                        return redirect()->back()->with('error', 'Arquivo não encontrado: ' . $doc->file);
                    }
                }

                $doc->delete();
            }
            return redirect()->back()->with('message', 'Itens excluídos com sucesso!');
        } else {
            return redirect()->back()->with('message', 'Itens excluídos com sucesso!');
        }
    }

    private function validation($data)
    {
        $rules = [
            'type' => 'required|string|in:linha,adendo',
            'description' => 'nullable|string',
        ];

        if ($data['type'] == "linha") {
            $rules = array_merge($rules, [
                'charge_next_invoice' => 'required|boolean',
                'phone' => 'required|string|min:10|max:15',
                'plan' => 'required|exists:plans,id',

            ]);
        } else if ($data['type'] == "adendo") {
            $rules = array_merge($rules, [
                'name_contract' => 'required|string|max:255',
                'value' => 'required|numeric|min:0',
                /* 'number_of_months' => 'required|integer|min:1', */
            ]);
        }

        $messages = [
            'type.required' => 'O campo tipo é obrigatório.',
            'type.string' => 'O campo tipo deve ser uma string.',
            'type.in' => 'O campo tipo deve ser "linha" ou "adendo".',

            'charge_next_invoice.required' => 'O campo "Cobrar a partir da próxima fatura?" é obrigatório.',
            'charge_next_invoice.boolean' => 'O campo "Cobrar a partir da próxima fatura?" deve ser verdadeiro ou falso.',

            'phone.required' => 'O campo número de contato é obrigatório.',
            'phone.string' => 'O campo número de contato deve ser uma string.',
            'phone.min' => 'O campo número de contato deve ter pelo menos 10 caracteres.',
            'phone.max' => 'O campo número de contato deve ter no máximo 15 caracteres.',

            'plan.required' => 'O campo plano é obrigatório.',
            'plan.exists' => 'O plano selecionado é inválido.',

            'name_contract.required' => 'O campo nome do contrato é obrigatório.',
            'name_contract.string' => 'O campo nome do contrato deve ser uma string.',
            'name_contract.max' => 'O campo nome do contrato deve ter no máximo 255 caracteres.',

            'value.required' => 'O campo valor é obrigatório.',
            'value.numeric' => 'O campo valor deve ser numérico.',
            'value.min' => 'O campo valor deve ser no mínimo 0.',

            'description.required' => 'O campo descrição é obrigatório.',
            'description.string' => 'O campo descrição deve ser uma string.',

            'number_of_months.required' => 'O campo número de meses é obrigatório.',
            'number_of_months.integer' => 'O campo número de meses deve ser um inteiro.',
            'number_of_months.min' => 'O campo número de meses deve ser no mínimo 1.',
        ];

        return Validator::make($data, $rules, $messages);
    }
}
