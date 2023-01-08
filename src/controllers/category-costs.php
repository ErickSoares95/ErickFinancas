<?php

use ErickFinancas\Models\CategoryCost;
use Psr\Http\Message\ServerRequestInterface;
$repository = $app->service('repository.factory')->factory(CategoryCost::class);
//Listagem da categorias
$app->get('/category-costs', function () use ($app, $repository) {
    $view = $app->service('view.renderer');
    $categories = $repository->all();
    return $view->render('category-costs/list.html.twig', [
        'categories' => $categories
    ]);
}, 'category-costs.list')
    //criar nova cateogira
    ->get('/category-costs/new', function () use ($app, $repository) {
        $view = $app->service('view.renderer');
        return $view->render('category-costs/create.html.twig');
    }, 'category-costs.new')
    ->post('/category-costs/store', function (ServerRequestInterface $request) use ($app, $repository) {
        //cadastro de category
        $data = $request->getParsedBody();
        $repository->create($data);
        return $app->route('category-costs.list');
    }, 'category-costs.store')
    //editar categoria
    ->get('/category-costs/{id}/edit', function (ServerRequestInterface $request) use ($app, $repository) {
        $view = $app->service('view.renderer');
        $id = $request->getAttribute('id');
        $category = $repository->find($id);
        return $view->render('category-costs/edit.html.twig', [
            'category' => $category
        ]);
    }, 'category-costs.edit')
    //dentro da view edit fazer a  atualização da categoria
    ->post('/category-costs/{id}/update', function (ServerRequestInterface $request) use ($app, $repository) {
        $id = $request->getAttribute('id');
        //eloquent pegando a categoria
        $category = $repository->find($id);
        //pegando dados enviados através da view
        $data = $request->getParsedBody();
        //passar todos os campos atribuidos no model para a variável e fazer as modificações
        $category->fill($data);
        $category->save();
        //passando um a um, que tem casos necessarios exemplo a seguir
        // $category->name = $data['name'];
        return $app->route('category-costs.list');
    }, 'category-costs.update')
    //na opcao de remover abrir uma pagina show para remoção ou edição
    ->get('/category-costs/{id}/show', function (ServerRequestInterface $request) use ($app, $repository) {
        $view = $app->service('view.renderer');
        $id = $request->getAttribute('id');
        $category = $repository->find($id);
        return $view->render('category-costs/show.html.twig', [
            'category' => $category
        ]);
        //delete category
    }, 'category-costs.show')
    ->get('/category-costs/{id}/delete', function (ServerRequestInterface $request) use ($app, $repository) {
        $id = $request->getAttribute('id');
        $category = $repository->find($id);
        $category->delete();
        return $app->route('category-costs.list');
    }, 'category-costs.delete');