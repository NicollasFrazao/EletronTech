<?php

declare(strict_types=1);

it('serves the home page', function (): void {
    $this->get('/')
        ->assertOk()
        ->assertSee('EletronTech')
        ->assertSee('v1 tag');
});

it('answers the health check', function (): void {
    $this->get('/up')->assertOk();
});
