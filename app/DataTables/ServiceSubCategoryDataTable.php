<?php

namespace App\DataTables;

use App\Models\Category;
use App\Models\ServiceSubCategory;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ServiceSubCategoryDataTable extends DataTable
{
    protected $category_slug;

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('image', function ($query) {
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
                    <select class="form-control form-control-sm status-select" data-id="' . $query->id . '" data-category-id="' .  $query->category_id  .'"  data-value="' . $query->status . '">
                        <option value="0" ' . $selectedDraft . '>No</option>
                        <option value="1" ' . $selectedPublished . '>Yes</option>
                    </select>
                ';
            })
            ->addColumn('action', function ($query) {
                return '
                    <a href="" class="btn-sm btn-primary">
                        <i class="ti ti-edit"></i>
                    </a> 
                    <a href="" class="btn-sm text-red delete-item">
                        <i class="ti ti-trash"></i>
                    </a>
                ';
            })            
            ->rawColumns(['image', 'status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    // public function query(ServiceSubCategory $model): QueryBuilder
    // {
    //     return $model->newQuery();
    // }

    public function query(ServiceSubCategory $model): QueryBuilder
    {
        // Resolve category_id from slug
        $category = Category::where('slug', $this->category_slug)->first();
        $categoryId = $category ? $category->id : null;

        return $model->newQuery()->where('category_id', $categoryId);
    }

    // Set the category_id for the query
    public function setCategoryId($category_slug)
    {
        $this->category_slug = $category_slug;
        return $this;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('servicesubcategory-table')
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
            Column::make('image'),
            Column::make('name')->title('Service Name'),
            Column::make('slug')->title('Slug'),
            Column::make('price')->title('Price')->width(60),
            Column::make('sale_price')->title('Sale Price')->width(60),
            Column::make('status')->title('Status')->width(60),
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
        return 'ServiceSubCategory_' . date('YmdHis');
    }
}
