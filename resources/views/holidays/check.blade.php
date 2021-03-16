@extends('layouts.app')
@section('content')
    <h2 class="content-title">Checking holidays on a given date</h2>
    <form action="/" method="post"> @csrf
        <div class="container">
            <div>
                <label for="check_date">Enter the date you want to
                    check:</label>
                <input class="input-date" type="date" id="check_date"
                       name="check_date"
                       value="{{ ($givenDate ?? now())->toDateString() }}"
                       required>
            </div>
            <input class="input-submit" type="submit" value="Submit">
        </div>
    </form>
    @error('check_date')
    @include('messages.simple', ['class' => 'message-error', 'text' => $message])
    @enderror
    @if(!empty($holidayInfo))
        @if(!empty($holidayInfo['is_day_off']))
            @include('messages.simple', ['class' => 'message-success', 'text' => __('holidays.day_off', ['name' => $holidayInfo['name']])])
        @else
            @include('messages.simple', ['class' => 'message-success', 'text' => trans_choice('holidays.check_result', 1, ['name' => $holidayInfo['name']])])
        @endif
    @elseif(isset($holidayInfo))
        @include('messages.simple', ['class' => 'message-info', 'text' => trans_choice('holidays.check_result', 0)])
    @endif
@endsection
