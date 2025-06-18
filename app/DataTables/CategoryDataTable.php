<?php

namespace App\DataTables;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CategoryDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('image', function($query){
            if ($query->image) {
                return '<img style="width:70px" src="' . asset($query->image) . '"></img>';
            } else {
                return 'No Image';
            }
        })


        ->addColumn('status', function ($query) {
            $selectedDraft = $query->status == '0' ? 'selected' : '';
            $selectedPublished = $query->status == '1' ? 'selected' : '';
        
            return '
                <select class="form-control form-control-sm status-select" data-id="' . $query->id . '" data-value="' . $query->status . '">
                    <option value="0" ' . $selectedDraft . '>No</option>
                    <option value="1" ' . $selectedPublished . '>Yes</option>
                </select>
            ';
        })


        ->addColumn('show_at_trending', function ($query) {
            $selectedDraft = $query->show_at_trending == '0' ? 'selected' : '';
            $selectedPublished = $query->show_at_trending == '1' ? 'selected' : '';
        
            return '
                <select class="form-control form-control-sm show_at_trending-select" data-id="' . $query->id . '" data-value="' . $query->show_at_trending . '">
                    <option value="0" ' . $selectedDraft . '>No</option>
                    <option value="1" ' . $selectedPublished . '>Yes</option>
                </select>
            ';
        })


        ->addColumn('action', function ($query) {
            return '
                <a href="' . route('admin.service.index', ['category' => $query->slug]) . '" class="btn-sm text-info">
                    <i class="ti ti-list"></i>
                </a> 
                <a href="' . route('admin.category.edit', $query->slug) . '" class="btn-sm btn-primary">
                    <i class="ti ti-edit"></i>
                </a> 
                <a href="" class="btn-sm text-red delete-item">
                    <i class="ti ti-trash"></i>
                </a>
            ';
        })  
        ->rawColumns(['action', 'image', 'status', 'show_at_trending'])
        ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Category $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('category-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(0)
                    // ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->width(60),
            Column::make('icon')->title('Icon')->width(60),
            Column::make('image'),
            Column::make('name')->title('Category Name'),
            Column::make('slug')->title('Slug'),
            Column::make('status')->title('Status')->width(60),
            Column::make('show_at_trending')->title('Trending')->width(60),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(160)
            ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Category_' . date('YmdHis');
    }
}
