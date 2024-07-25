<?php

namespace App\Http\Controllers\Cms;

use App\Clients;
use App\Traits\SlugTrait;
use App\Helpers\CmsHelper;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Cms\RestrictedController;

class ClientsController extends RestrictedController
{
  use UploadTrait;
  Use SlugTrait;

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $data = $request->all();
    #PAGE TITLE E BREADCRUMBS
    $headers = parent::headers(
      "Clientes",
      [
        [
          "icon" => "",
          "title" => "Clientes",
          "url" => "",
        ],
      ]
    );
    #LISTA DE ITENS
    $titles = json_encode(["#", "Imagem", "Status", "Nome", "E-mail", "CPF", ]);
    $actions = json_encode([
      [
        'path' => '{item}/edit',
        'icon' => 'fa fa-pencil',
        'label' => 'Editar Perfil',
        'color' => 'primary',
      ],
      [
        'path' => '{item}/timeline',
        'icon' => 'fa fa-info-circle',
        'label' => 'Sobre o cliente',
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
    $items = Clients::select('id', 'image', 'active', 'name', 'email', "CPF",)
      ->where(function ($query) use ($data) {
        if (!empty($data['busca'])) {
          $query->where('name', 'LIKE', "%" . $data['busca'] . "%");
        }
      })
      ->orWhere(function ($query) use ($data) {
        if (!empty($data['busca'])) {
          $query->where('email', 'LIKE', "%" . $data['busca'] . "%");
        }
      })
      ->orWhere(function ($query) use ($data) {
        if (!empty($data['busca'])) {
          $query->where('id', $data['busca']);
        }
      })
      ->orderBy('id', 'asc')
      ->paginate($pagination);

    foreach ($items as $item) {
      $item['active'] = [
        'type' => 'badge',
        'status' => $item['active'] == 1 ? 'success' : 'danger',
        'text' => $item['active'] == 1 ? 'Ativo' : 'Inativo'
      ];
    }

    return view('cms.clients.index', compact('headers', 'titles', 'items', 'busca', 'actions'));
  }

  public function store(Request $request)
  {
    $data = $request->all();

    $validation = $this->validation($data, 'store');
    if ($validation->fails()) {
      return redirect()->back()->withErrors($validation)->withInput();
    }

    if (!empty($data['image'])) {
      if (!$image = $this->uploadValidFile('clients', $data['image'], 800)) {
        return redirect()->back()->withErrors(['errors' => 'image cannot be uploaded'])->withInput();
      }
    }

    if (!empty($image)){
      $data['image'] = $image;
    }

    $data['active'] = CmsHelper::CheckboxCheck(isset($data['active']));
    $data['slug'] = $this->getSlug($data['name'], 'clients');
    $clients = Clients::create($data);

    return redirect()->back()->with('message', 'Registro cadastrado com sucesso!');

    
  }
  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Clients  $clients
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    #PAGE TITLE E BREADCRUMBS
    $headers = parent::headers(
      "Clientes",
      [
        ["icon" => "", "title" => "Clientes", "url" => route('clients.index')],
        ["icon" => "", "title" => "Editar", "url" => ""],
      ]
    );

    $clients = Clients::find($id);
    /* $clients = Clients::select(
      'id',
      'active',
      'email as E-mail',
      'name as Nome'      
    )
    ->where('id',$id)->first();

    if (empty($clients)) {
      return redirect()->back();
    }

    $inputs = $clients->toArray();
    unset($inputs['id'],$inputs['active']); */
    $clients->image = asset($clients->image);
    
    return view('cms.clients.edit', compact('headers', 'clients'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Clients  $clients
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $data = $request->all();

    $client = Clients::find($id);
    $data['active'] = CmsHelper::CheckboxCheck(isset($data['active']));

    $validation = $this->validation($data);
    if ($validation->fails()) {
      return redirect()->back()->withErrors($validation)->withInput();
    }
    $image = $client->image;
    if ($request->hasFile('image')) {
      if (!$image = $this->uploadValidFile('clients', $data['image'], 800)) {
        return redirect()->back()->withErrors(['errors' => 'image cannot be uploaded'])->withInput(); 
      }

      unlink($client->image);
    }

    $data['image'] = $image;

    $client->update($data);
    return redirect()->route('clients.index')->with('message', 'Registro atualizado com sucesso!');
  }

  public function destroy(Request $request)
  {
    $data = $request->all();
    
    $clients = Clients::whereIn('id', $data['registro'])->get();
    foreach ($clients as $client) {
      if (!empty($client->image)) {
        unlink($client->image);
      }
      $client->delete();
    }
    
    return redirect()->back()->with('message', 'Itens excluídos com sucesso!');
  }

  private function validation(array $data)
  {
    $validator = [
      'cpf' => 'required|string|max:14|unique:clients',
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:clients',
/*       'whatsapp' => 'required|string|max:255', 
      'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', */

    ];

    $messages = [
      'image' => 'A imagem não pode ser carregada',
      'image.required' => 'É necessário preencher o campo de imagem',
      'name.required' => 'É necessário preencher o campo de nome',
      'email.required' => 'É necessário preencher o campo de email',
      'whatsapp.required' => 'É necessário preencher o campo de whatsapp',
      'cpf.required' => 'É necessário preencher o campo de cpf',
      'cpf.max' => 'O número máximo de caracteres é de 14',
      'name.max' => 'O número máximo de caracteres é de 255',
      'email.max' => 'O número máximo de caracteres é de 255',
      'whatsapp.max' => 'O número máximo de caracteres é de 255',
      'email.unique' => 'O e-mail informado já está em uso',
      'cpf.unique' => 'O CPF informado já está em uso',
    
    ];


    $valid = Validator::make($data, $validator, $messages);


    return $valid;
  }
}
