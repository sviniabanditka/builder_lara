@if (count($rows))
    @foreach ($rows as $row)
        <?php $row = $row->toArray();?>
        @include('admin::tb.single_row')
    @endforeach
@else
    <tr><td colspan="100%">{{ $def['options']['not_found'] or 'No data found' }}</td></tr>
@endif
