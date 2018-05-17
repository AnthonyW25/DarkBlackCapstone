<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExpenseControllerTest extends TestCase
{
    /** @test */
    public function index()
    {
        $this->actingAs($this->user)
            ->get('/expense')
            ->assertSuccessful()
            ->assertSee('expenses');

        // Also should see a list of existing expenses

        // Create an Expense we can expect to see
        $expense = expense::create([
            'supplier' => 'Test Supplier',
            // other expense details
        ]);

        $expense_item = expenseitem::create([
            'expense_id' => $expense->id,
            // other expense details
        ]);

        $this->actingAs($this->user)
            ->get('/expense')
            ->assertSee('the expense details');
    }

     /*/**

     /** @test */
     public function create()
     {
        $this->actingAs($this->user)
             ->get('/expense/create')
             ->assertSee('Create an Expense');
     }

    // /** @test */
    // public function store()
    // {
    //     $this->actingAs($this->user)
    //         ->post('/Expense/create', [
    //             'supplier' => 'Test Supplier',
    //             // other post variables
    //         ])
    //         ->assertRedirect('/Expense');

    //     // we should now have records in the expenses and expense_items table
    //     $this->assertDatabaseHas('expenses', [
    //         'supplier' => 'Test Supplier',
    //         // other expense details
    //     ]);

    //     // get the expense from the db so we know it's id
    //     $expense = Expense::first();

    //     $this->assertDatabaseHas('expense_items', [
    //         'expense_id' => $expense->id,
    //         // expense_item details
    //     ]);

    //     // Should also post some invalid data to test the controllers response
    // }

    // /** @test */
    // public function edit()
    // {
    //     $this->actingAs($this->user)
    //         ->get('/Expense/edit')
    //         ->assertSee('Edit Expense');
    // }

    // /** @test */
    // public function update()
    // {
    //     // create an expense we can edit

    //     $expense = Expense::create([
    //         'supplier' => 'Test Supplier',
    //         // other expense details
    //     ]);

    //     $expense_item = ExpenseItem::create([
    //         'expense_id' => $expense->id,
    //         // other expense details
    //     ]);

    //     // Post changed data to test the ability to edit

    //     $this->actingAs($this->user)
    //         ->post('/Expense/edit', [
    //             // other post variables
    //         ])
    //         ->assertRedirect('/Expense');

    //     // Check the db to see the records have changed

    //     $this->assertDatabaseHas('expenses', [
    //         'id' => $expense->id
    //         // other expense details
    //     ]);

    //     $this->assertDatabaseHas('expense_items', [
    //         'id' => $expense_item->id
    //         // expense_item details
    //     ]);

    //     // Should also post some invalid data to test the controllers response
    // }

    // /** @test */
    // public function delete()
    // {
    //     // create an expense we can delete

    //     $expense = Expense::create([
    //         'supplier' => 'Test Supplier',
    //         // other expense details
    //     ]);

    //     $expense_item = ExpenseItem::create([
    //         'expense_id' => $expense->id,
    //         // other expense details
    //     ]);

    //     $this->actingAs($this->user)
    //         ->post('/Expense/delete', [
    //             'id' => $expense->id
    //         ])
    //         ->assertRedirect('/Expense');

    //     // The database should no longer have the records

    //     $this->assertDatabaseMissing('expenses', [
    //         'id' => $expense->id
    //     ]);

    //     $this->assertDatabaseMissing('expense_items', [
    //         'id' => $expense_item->id
    //     ]);
    // }

    // */*/
}
