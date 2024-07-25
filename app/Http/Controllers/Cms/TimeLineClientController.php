<?php

namespace App\Http\Controllers\Cms;

use App\Clients;
use App\TimeLineClient;
use App\Traits\SlugTrait;
use App\Helpers\CmsHelper;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Cms\RestrictedController;


class TimeLineClientController extends RestrictedController
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
        $titles = json_encode(["#","Ativo", "Titulo", "Sub Título", "Data", "Imagem"]);
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
        $items = TimeLineClient::select('id',"active" ,'title', 'lead', 'date', 'image')->where('client_id', $id)
            ->where(function ($query) use ($data) {
                if (!empty($data['busca'])) {
                    $query->where('title', 'LIKE', "%" . $data['busca'] . "%");
                }
            })->orWhere(function ($query) use ($data) {
                if (!empty($data['busca'])) {
                    $query->where('id', $data['busca']);
                }
            })->orderBy('id', 'asc')
            ->paginate($pagination);

            foreach ($items as $item) {
                $item['active'] = [
                  'type' => 'badge',
                  'status' => $item['active'] == 1 ? 'success' : 'danger',
                  'text' => $item['active'] == 1 ? 'Ativo' : 'Inativo'
                ];
            }

        return view('cms.clients.timeline.index', compact('headers', 'titles', 'items', 'busca', 'actions', 'clients'));
    }


    public function store(Request $request, $client_id)
    {
        $data = $request->all();
        $validator = $this->validation($data);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        if (!empty($data['image'])) {
            if (!$image = $this->uploadValidFile('timeline', $data['image'], 800)) {
              return redirect()->back()->withErrors(['errors' => 'image cannot be uploaded'])->withInput();
            }

            $data['image'] = $image;
        }
        if (!empty($data['audio'])) {
            if (!$audio = $this->uploadValidFile('timeline', $data['audio'])) {
                return redirect()->back()->withErrors(['errors' => 'Audio cannot be uploaded'])->withInput();
            }
            $data['audio'] = $audio;
        }
        if (!empty($data['video'])) {
            if (!$video = $this->uploadValidFile('timeline', $data['video'])) {
                return redirect()->back()->withErrors(['errors' => 'Audio cannot be uploaded'])->withInput();
            }
            $data['video'] = $video;
        }
        

        $data['active'] = CmsHelper::CheckboxCheck(isset($data['active']));
        $data['client_id'] = $client_id;
        TimeLineClient::create($data);
        
        return redirect()->back()->with('message', 'Registro cadastrado com sucesso!');
    }

    public function update(Request $request, $client_id, $id)
    {
        $data = $request->all();

        $validation = $this->validation($data);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $timeline = TimeLineClient::where('id', $id)->first();
       
        $image = $timeline->image;
        if ($request->hasFile('image')) {
          if (!$image = $this->uploadValidFile('timeline', $data['image'], 800)) {
            return redirect()->back()->withErrors(['errors' => 'image cannot be uploaded'])->withInput(); 
          }
          unlink($timeline->image);

          $data['image'] = $image;
        }

        if ($request->hasFile('audio')) {
          if (!$audio = $this->uploadValidFile('timeline', $data['audio'])) {
            return redirect()->back()->withErrors(['errors' => 'Audio cannot be uploaded'])->withInput();
          }
          unlink($timeline->audio);
          $data['audio'] = $audio;
        }

        $data['active'] = CmsHelper::CheckboxCheck(isset($data['active']));
        $timeline->update($data);

        return redirect()->route('clients.timeline.index', $client_id)->with('message', 'Registro atualizado com sucesso!');
    }

    public function edit($id_product, $item_doc)
    {
        #PAGE TITLE E BREADCRUMBS
        $headers = parent::headers(
            "Timeline do Cliente",
            [
                ["icon" => "", "title" => "Itens", "url" => route('clients.timeline.index', [$id_product, $item_doc])],
                ["icon" => "", "title" => "Editar", "url" => ""],
            ]
        );

        $item = TimeLineClient::where('id', $item_doc)->first();

        if (empty($item)) {
            return redirect()->back();
        }

        return view('cms.clients.timeline.edit', compact('headers','item', 'id_product',));
    }

    public function destroy(Request $request)
    {
        $data = $request->all();

        if (isset($data['registro'])) {
            $timeline = TimeLineClient::whereIn('id', $data['registro'])->get();
            
            foreach ($timeline as $information) {
                $information->delete();
            }
            return redirect()->back()->with('message', 'Itens excluídos com sucesso!');
        }
    }

    private function validation($data)
    {
        $rules = [
            'title' => 'required|string',
            'description' => 'required|string',
        ];

        $messages = [
            'title.required' => 'O campo Título é obrigatório.',
            'description.required' => 'O campo descrição é obrigatório.',
        ];

        return Validator::make($data, $rules, $messages);
    }
}
