<?php

use Psr\Http\Message\ServerRequestInterface;

//Listagem da categorias
$app->get('/category-costs', function () use ($app) {
    $view = $app->service('view.renderer');
    $repository = $app->service('category-cost.repository');
    $categories = $repository->all();
    return $view->render('category-costs/list.html.twig', [
        'categories' => $categories
    ]);
}, 'category-costs.list')
    //criar nova cateogira
    ->get('/category-costs/new', function () use ($app) {
        $view = $app->service('view.renderer');
        return $view->render('category-costs/create.html.twig');
    }, 'category-costs.new')
    ->post('/category-costs/store', function (ServerRequestInterface $request) use ($app) {
        //cadastro de category
        $data = $request->getParsedBody();
        $repository = $app->service('category-cost.repository');
        $repository->create($data);
        return $app->route('category-costs.list');
    }, 'category-costs.store')
    //editar categoria
    ->get('/category-costs/{id}/edit', function (ServerRequestInterface $request) use ($app) {
        $view = $app->service('view.renderer');
        $repository = $app->service('category-cost.repository');
        $id = $request->getAttribute('id');
        $category = $repository->find($id);
        return $view->render('category-costs/edit.html.twig', [
            'category' => $category
        ]);
    }, 'category-costs.edit')
    //dentro da view edit fazer a  atualização da categoria
    ->post('/category-costs/{id}/update', function (ServerRequestInterface $request) use ($app) {
        $repository = $app->service('category-cost.repository');
        $id = $request->getAttribute('id');
        //eloquent pegando a categoria
        $data = $request->getParsedBody();
        $repository->update($id, $data);
        //passando um a um, que tem casos necessarios exemplo a seguir
        // $category->name = $data['name'];
        return $app->route('category-costs.list');
    }, 'category-costs.update')
    //na opcao de remover abrir uma pagina show para remoção ou edição
    ->get('/category-costs/{id}/show', function (ServerRequestInterface $request) use ($app) {
        $view = $app->service('view.renderer');
        $repository = $app->service('category-cost.repository');
        $id = $request->getAttribute('id');
        $category = $repository->find($id);
        return $view->render('category-costs/show.html.twig', [
            'category' => $category
        ]);
        //delete category
    }, 'category-costs.show')
    ->get('/category-costs/{id}/delete', function (ServerRequestInterface $request) use ($app) {
        $repository = $app->service('category-cost.repository');
        $id = $request->getAttribute('id');
        $repository->delete($id);
        return $app->route('category-costs.list');
    }, 'category-costs.delete');