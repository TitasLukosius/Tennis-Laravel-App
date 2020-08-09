<form
    {!!html_attr(($attr ?? []) + ['method' => 'POST'])!!}>
    @csrf
    @foreach($fields ?? [] as $field_id => $field)
        <div>
            <label>{{$field['label'] ?? ''}}</label>
            @if(in_array($field['type'], ['text', 'password', 'email', 'number', 'color', 'hidden', 'date', 'time', 'file']))
                <input {!!input_attr($field_id, $field) !!} >
            @elseif(in_array($field['type'], ['radio']))
                @foreach ($field['options'] as $option_id => $option)
                    <label>{{ $option['label'] }}</label>
                    <input {!!radio_attr($field, $field_id, $option_id) !!} >
                @endforeach
            @elseif(in_array($field['type'], ['select']))
                <select {!!select_attr($field_id, $field) !!} >
                    @foreach($field['options'] as $option_id => $option)
                        <option {!!option_attr($option_id, $field)!!} >
                            {!!$option!!}
                        </option>
                    @endforeach
                </select>
            @elseif(in_array($field['type'], ['textarea']))
                <textarea {!!textarea_attr($field_id, $field)!!} >
                    {!! $field['value'] ?? '' !!}
                </textarea>
            @endif
            @if($errors->has($field_id))
                <span class="red">{!!$errors->first($field_id)!!}</span>
            @endif
        </div>
    @endforeach
    @foreach($buttons ?? [] as $button_id => $button)
        <button {!!html_attr(($button['extra']['attr'] ?? []) + ['value' => $button_id, 'name' => 'action'])!!} >
            {!!$button['text']!!}
        </button>
    @endforeach
</form>
