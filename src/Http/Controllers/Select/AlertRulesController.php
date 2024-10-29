<?php

namespace DotMike\NmsWidgetAlertRules\Http\Controllers\Select;

use App\Models\AlertRule;
use App\Http\Controllers\Select\SelectController;

class AlertRulesController extends SelectController
{
    protected function searchFields($request)
    {
        return ['name'];
    }

    protected function baseQuery($request)
    {
        return AlertRule::select('id', 'name');
    }

    /**
     * @param  AlertRule  $alert_rule
     */
    public function formatItem($alert_rule)
    {
        return [
            'id' => $alert_rule->id,
            'text' => $alert_rule->name,
        ];
    }
}
