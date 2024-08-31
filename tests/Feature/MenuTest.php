<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Menu;
use App\Models\MenuItem;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test fetching all menus.
     *
     * @return void
     */
    public function test_can_fetch_all_menus()
    {
        Menu::factory()->count(3)->create();

        $response = $this->getJson('/api/menus');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    /**
     * Test fetching a specific menu.
     *
     * @return void
     */
    public function test_can_fetch_specific_menu()
    {
        $menu = Menu::factory()->create();

        $response = $this->getJson('/api/menus/' . $menu->id);

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $menu->id,
            'name' => $menu->name,
        ]);
    }

    /**
     * Test creating a menu.
     *
     * @return void
     */
    public function test_can_create_menu()
    {
        $menuData = [
            'name' => 'Main Menu',
        ];

        $response = $this->postJson('/api/menus', $menuData);

        $response->assertStatus(201);
        $response->assertJson($menuData);
        $this->assertDatabaseHas('menus', $menuData);
    }

    /**
     * Test updating a menu.
     *
     * @return void
     */
    public function test_can_update_menu()
    {
        $menu = Menu::factory()->create();
        $updatedData = [
            'name' => 'Updated Menu',
        ];

        $response = $this->putJson('/api/menus/' . $menu->id, $updatedData);

        $response->assertStatus(200);
        $response->assertJson($updatedData);
        $this->assertDatabaseHas('menus', $updatedData);
    }

    /**
     * Test deleting a menu.
     *
     * @return void
     */
    public function test_can_delete_menu()
    {
        $menu = Menu::factory()->create();

        $response = $this->deleteJson('/api/menus/' . $menu->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('menus', ['id' => $menu->id]);
    }

    /**
     * Test creating a menu item.
     *
     * @return void
     */
    public function test_can_create_menu_item()
    {
        $menu = Menu::factory()->create();
        $itemData = [
            'name' => 'Menu Item 1',
            'menu_id' => $menu->id,
            // Add other fields relevant to your MenuItem model
        ];

        $response = $this->postJson('/api/menus/' . $menu->id . '/items', $itemData);

        $response->assertStatus(201);
        $response->assertJson($itemData);
        $this->assertDatabaseHas('menu_items', $itemData);
    }

    /**
     * Test updating a menu item.
     *
     * @return void
     */
    public function test_can_update_menu_item()
    {
        $menuItem = MenuItem::factory()->create();
        $updatedData = [
            'name' => 'Updated Menu Item',
            // Add other fields you want to update
        ];

        $response = $this->putJson('/api/menu-items/' . $menuItem->id, $updatedData);

        $response->assertStatus(200);
        $response->assertJson($updatedData);
        $this->assertDatabaseHas('menu_items', $updatedData);
    }

    /**
     * Test deleting a menu item.
     *
     * @return void
     */
    public function test_can_delete_menu_item()
    {
        $menuItem = MenuItem::factory()->create();

        $response = $this->deleteJson('/api/menu-items/' . $menuItem->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('menu_items', ['id' => $menuItem->id]);
    }
}
