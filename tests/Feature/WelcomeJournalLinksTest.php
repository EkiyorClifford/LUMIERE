<?php

use Illuminate\Http\Request;

test('welcome journal read more cards link to the journal', function () {
    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertSee('href="'.route('journal').'"', false)
        ->assertSeeText('READ MORE');
});

test('journal category route resolves before journal post slugs', function () {
    $request = Request::create('/journal/category/craftsmanship', 'GET');

    $route = app('router')->getRoutes()->match($request);

    expect($route->getName())->toBe('post.category');
});
