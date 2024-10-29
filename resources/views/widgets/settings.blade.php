@extends('widgets.settings.base')
@section('form')
<div class="form-group">
    <label for="title-{{ $id }}" class="control-label">{{ __('Widget title') }}</label>
    <input type="text" class="form-control" name="title" id="title-{{ $id }}" placeholder="{{ __('Custom title') }}" value="{{ $title }}">
</div>
<div class="form-group">
    <label for="alert_rules-{{ $id }}" class="control-label">{{ __('Alert rule') }}</label>
    <select multiple class="form-control" name="alert_rules[]" id="alert_rules-{{ $id }}" data-placeholder="{{ __('Select or add one or more') }}">
        @foreach($alert_rules as $alert_rule)
        <option value="{{ $alert_rule->id }}" selected>{{ $alert_rule->name }}</option>
        @endforeach
    </select>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
    init_select2('#alert_rules-{{ $id }}', 'alert-rules', {});
</script>
@endsection