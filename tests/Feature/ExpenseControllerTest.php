<?php

namespace Tests\Feature;

use App\Expense;
use App\ExpenseItem;
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
            ->assertSee('Expense List');

        // Also should see a list of existing expenses

        // Create an Expense we can expect to see
        $expense = Expense::create([
            'supplier' => 'Test Supplier',
            // other expense details
        ]);

        $expense_item = ExpenseItem::create([
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

    /** @test */
    public function store()
    {
        $this->actingAs($this->user)
            ->post('/expense/create', [
                'supplier' => 'Test Supplier',
                'invoice'  => 'Test Invoice'
                // other post variables
            ])
            ->assertRedirect('/expense');

        //we should now have records in the expenses and expense_items table
        $this->assertDatabaseHas('expenses', [
            'supplier' => 'Test Supplier'
            // other expense details
        ]);

        // get the expense from the db so we know it's id
        $expense = Expense::first();

        //Mgodby: Added this so the expense item is created
        $expense_item = ExpenseItem::create([
            'expense_id' => $expense->id,
            // other expense details
        ]);

        $this->assertDatabaseHas('expense_items', [
            'expense_id' => $expense->id,
            // expense_item details
        ]);
        // Should also post some invalid data to test the controllers response
    }

    /** @test */
    public function edit()
    {
        $expense = Expense::create([
            'supplier' => 'Test Supplier',
            // other expense details
        ]);

        $this->actingAs($this->user)
            ->get('/expense/' . $expense->id . '/edit')
            ->assertSee('Edit Expense');
    }

    /** @test */
    public function update()
    {
        //create an expense we can edit

        $expense = Expense::create([
            'supplier' => 'Test Supplier',
            'invoice'  => 'Test Invoice'
            // other expense details
        ]);

        $expense_item = ExpenseItem::create([
            'expense_id' => $expense->id,
            // other expense details
        ]);

        // Post changed data to test the ability to edit

        $this->actingAs($this->user)
            ->post('/expense/' . $expense->id . '/edit', [
                'supplier' => 'new name',
                'invoice'  => 'new invoice'
                // other post variables
            ])
            ->assertRedirect('/expense');

        // Check the db to see the records have changed

        $this->assertDatabaseHas('expenses', [
            'id' => $expense->id
            // other expense details
        ]);

        $this->assertDatabaseHas('expense_items', [
            'id' => $expense_item->id
            // expense_item details
        ]);
        //Should also post some invalid data to test the controllers response
    }

    /** @test */
    public function destroy()
    {
        // create an expense we can delete

        $expense = Expense::create([
            'supplier' => 'Test Supplier',
            'invoice'  => 'Test Invoice'
            // other expense details
        ]);

        $expense_item = ExpenseItem::create([
            'expense_id' => $expense->id,
            // other expense details
        ]);

        $this->actingAs($this->user)
            ->post('/expense/' . $expense->id . '/delete', [
                'id' => $expense->id
            ])
            ->assertRedirect('/expense');

        // The database should no longer have the records

        $this->assertDatabaseMissing('expenses', [
            'id' => $expense->id
        ]);

        $this->assertDatabaseMissing('expense_items', [
            'id' => $expense_item->id
        ]);
    }

    /** @test */
    public function show()
    {
        $expense = Expense::create([
            'supplier' => 'Test Supplier',
            'invoice'  => 'Test Invoice'
            // other expense details
        ]);

        $expense_item = ExpenseItem::create([
            'expense_id' => $expense->id,
            // other expense details
        ]);

        $this->actingAs($this->user)
            ->get('/expense/' . $expense->id)
            ->assertSee($expense->supplier);
    }
}
