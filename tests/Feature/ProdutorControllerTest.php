<?php

namespace Tests\Feature;

use App\Models\Produtor;
use App\Models\Propriedade;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProdutorControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_can_create_a_producer(): void
    {
        $produtorData = [
            'nome' => 'João da Silva',
            'cpf_cnpj' => '123.456.789-00',
            'email' => 'joao@example.com',
            'telefone' => '(85) 99999-8888',
        ];

        $response = $this->actingAs($this->user)
            ->post(route('produtores.store'), $produtorData);

        $this->assertDatabaseHas('produtores', ['cpf_cnpj' => '123.456.789-00']);

        $response->assertRedirect(route('produtores.index'));
        $response->assertSessionHas('success', 'Produtor criado com sucesso.');
    }

    public function test_can_update_a_producer(): void
    {
        $produtor = Produtor::factory()->create();

        $updateData = [
            'nome' => 'João da Silva Santos',
            'cpf_cnpj' => $produtor->cpf_cnpj,
            'email' => 'joao.novo@email.com',
        ];

        $response = $this->actingAs($this->user)
            ->put(route('produtores.update', $produtor), $updateData);

        $produtor->refresh();

        $this->assertEquals('João da Silva Santos', $produtor->nome);
        $this->assertEquals('joao.novo@email.com', $produtor->email);

        $response->assertRedirect(route('produtores.show', $produtor));
    }

    public function test_can_delete_a_producer_without_properties(): void
    {
        $produtor = Produtor::factory()->create();

        $response = $this->actingAs($this->user)
            ->delete(route('produtores.destroy', $produtor));

        $this->assertDatabaseMissing('produtores', ['id' => $produtor->id]);
        $response->assertRedirect(route('produtores.index'));
    }

    public function test_cannot_delete_a_producer_with_linked_properties(): void
    {
        $produtor = Produtor::factory()->create();
        Propriedade::factory()->create(['produtor_id' => $produtor->id]);

        $response = $this->actingAs($this->user)
            ->delete(route('produtores.destroy', $produtor));

        $this->assertDatabaseHas('produtores', ['id' => $produtor->id]);

        $response->assertSessionHasErrors();
    }
}
