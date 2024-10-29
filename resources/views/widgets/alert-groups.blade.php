<x-panel class="table-responsive">
    <x-slot name="table">
        <table class="table table-hover table-condensed table-striped">
            <thead>
                <tr>
                    <th>{{ __('Alert Rule') }}</th>
                    <th>{{ __('Active Alerts') }}</th>
                    <th>{{ __('Acknowledged') }}</th>
                    <th>{{ __('Worse') }}</th>
                    <th>{{ __('Better') }}</th>
                    <th>{{ __('Recovered') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alertRules as $rule)
                <tr>
                    <td><a href="{{ url('alert-rules', $rule['id']) }}">{{ $rule['name'] }}</a></td>
                    <td><a href="{{ url('alerts/rule_id=' . $rule['id']) }}"><span class="red">{{ $rule['alerts_active'] }}</span></a></td>
                    <td><span class="orange">{{ $rule['alerts_acknowledged'] }}</span></td>
                    <td><span>{{ $rule['alerts_worse'] }}</span></td>
                    <td><span>{{ $rule['alerts_better'] }}</span></td>
                    <td><span>{{ $rule['alerts_recovered'] }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </x-slot>
</x-panel>