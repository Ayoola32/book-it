<?php

namespace App\DataTables;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AppointmentDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $statusColors = [
            'Pending' => '#f39c12',
            'Processing' => '#3498db',
            'Confirmed' => '#2ecc71',
            'Cancelled' => '#ff0000',
            'Completed' => '#008000',
            'On Hold' => '#95a5a6',
            'Rescheduled' => '#f1c40f',
            'No Show' => '#e67e22',
        ];



        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('service_id', function ($query) {
                return '
                    <span class="">' . $query->service->name . '</span>

                ';
            })            
            ->addColumn('employee_id', function ($query) {
                return '
                    <span class="">' . $query->employee->user->name . '</span>

                ';
            })            
            ->addColumn('status', function ($query) use ($statusColors) {
                $status = $query->status;
                $color = $statusColors[$status] ?? '#7f8c8d';

                return '
                    <span class="badge px-2 py-1"
                        style="background-color: ' . $color . '; color: white;">
                        ' . $status . '
                    </span>
                ';
            })            
            ->addColumn('action', function ($appointment) {
                return '
                    <button class="btn btn-primary btn-sm py-0 px-1 view-appointment-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#appointmentModal"
                        data-id="' . $appointment->id . '"
                        data-name="' . e($appointment->name) . '"
                        data-service="' . e($appointment->service->name ?? 'N/A') . '"
                        data-email="' . e($appointment->email) . '"
                        data-phone="' . e($appointment->phone) . '"
                        data-employee="' . e($appointment->employee->user->name ?? 'N/A') . '"
                        data-start="' . e($appointment->booking_date . ' ' . $appointment->booking_time) . '"
                        data-amount="' . e($appointment->amount) . '"
                        data-notes="' . e($appointment->notes) . '"
                        data-status="' . e($appointment->status) . '">
                        View
                    </button>
                ';
            })           
            ->rawColumns(['service_id', 'employee_id', 'status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Appointment $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('appointment-table')
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
            Column::computed('DT_RowIndex')->title('#')->width(30)->addClass('text-center'),
            Column::make('name')->title('Full Name'),
            Column::make('email')->title('Email'),
            Column::make('phone')->title('Phone'),
            Column::make('amount')->title('Amount'),
            Column::make('service_id')->title('Service'),
            Column::make('employee_id')->title('Staff'),
            Column::make('booking_date')->title('Date'),
            Column::make('booking_time')->title('Time'),
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
        return 'Appointment_' . date('YmdHis');
    }
}
