<?php

declare(strict_types=1);

namespace App\Services;


class StatusHandlerService
{
    public function activeData(object $model): void
    {
        $data = $model;
        $data->is_active = true;
        $data->update();
    }

    public function inactiveData(object $model) : void
    {
        $data = $model;
        $data->is_active = 0;
        $data->update();
    }

    public function bulkActionData(string $actionType, $model): string
    {
        $data = $model;

        if ($actionType == 'active') {

            $data->update(['is_active' => 1]);

            return 'Data Active Successfully';

        } else if ($actionType == 'inactive') {

            $data->update(['is_active' => 0]);

            return 'Data Inactive Successfully';

        } else if ($actionType == 'delete') {

            $data->delete();

            return 'Data Deleted Successfully';
        }
    }
}
