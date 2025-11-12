<?php

namespace DotMike\NmsWidgetAlertRules\Http\Controllers\Widgets;

use App\Models\Device;
use App\Models\DeviceGroup;
use App\Models\Alert;
use App\Models\AlertRule;
use App\Facades\DeviceCache;

use LibreNMS\Enum\AlertState;

use App\Http\Controllers\Widgets\WidgetController;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class AlertRulesController extends WidgetController
{

    protected $title = 'Alert Rules';
    protected $defaults = [
        'title' => null,
        'alert_rules' => [],
    ];

    public function getView(Request $request)
    {
        $settings = $this->getSettings();

        $query = AlertRule::withCount(
            [
                'alerts as alerts_active' => function ($query) {
                    //$query->where('state', AlertState::ACTIVE);
                    $query->whereIn('state', [AlertState::ACTIVE, AlertState::CHANGED]);
                },
                'alerts as alerts_acknowledged' => function ($query) {
                    $query->where('state', AlertState::ACKNOWLEDGED);
                },
                'alerts as alerts_worse' => function ($query) {
                    $query->where('state', AlertState::WORSE);
                },
                'alerts as alerts_better' => function ($query) {
                    $query->where('state', AlertState::BETTER);
                },
                'alerts as alerts_recovered' => function ($query) {
                    $query->where('state', AlertState::RECOVERED);
                },
            ]
        );
        if (!empty($settings['alert_rules'])) {
            $query = $query->whereIn('id', $settings['alert_rules']);
        }

        $query = $query->get();

        return view('nmswidgetalertrules::widgets.alert-groups', ['alertRules' => $query]);
    }

    public function getSettingsView(Request $request)
    {
        $data = $this->getSettings(true);
        $data['alert_rules'] = AlertRule::whereIn('id', $data['alert_rules'])->get(['id', 'name']);
        return view('nmswidgetalertrules::widgets.settings', $data);
    }
}
