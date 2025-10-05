@extends('app')
@section('content')
<div class="card mt-5">
	<div class="card-body">
		<table id="table1" class="table table-bordered table-hover table-cursor-pointer">
			<thead>
				<tr>
					<th>#</th>
					<th>Attention</th>
					<th>Name</th>
					<th>Locations</th>
					<th>
						<select class="form-control prop_select">
							<option value="">Type</option>
							<option value="H">House</option>
                            <option value="A">Apartments</option>
                            <option value="HA">H/A</option>
						</select>
                    </th>
					<th>Waiting list</th>
					<th>Current</th>
					<th>Note</th>
					<th></th>
					<th></th>
                    <th></th>
				</tr>
			</thead>
			<tbody>
				<tr>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th>#</th>
					<th>Attention</th>
					<th>Name</th>
					<th>Locations</th>
					<th>
						<select class="form-control prop_select">
							<option value="">Type</option>
							<option value="H">House</option>
                            <option value="A">Apartments</option>
                            <option value="HA">H/A</option>
						</select>
                    </th>
					<th>Waiting list</th>
					<th>Current</th>
					<th>Note</th>
					<th></th>
					<th></th>
                    <th></th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

@push('scripts')
<script src="/js/jquery.dataTables.js"></script>
<script src="/js/dataTables.bootstrap4.js"></script>
<script src="/js/dataTables.responsive.js"></script>
<script src="/js/responsive.bootstrap4.js"></script>
<script src="/js/dataTables.buttons.js"></script>
<script src="/js/buttons.bootstrap4.js"></script>
<script src="/js/jszip.js"></script>
<script src="/js/pdfmake.js"></script>
<script src="/js/vfs_fonts.js"></script>
<script src="/js/buttons.html5.js"></script>
<script src="/js/buttons.print.js"></script>
<script src="/js/buttons.colVis.js"></script>
<script>
$().ready(function(){
	var table;
	function InitializeTable(url) {
		var initTable = {
			"dom": '<"top"Bf>rt<"bottom"lp><"clear">',
			serverSide: true,
			autoWidth: true,
			responsive: false,
			lengthChange: false,
			lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
			columns: [
				{data: 'id', name: 'id'},
                {data: 'actions', name: 'actions', 'searchable': false, 'orderable': false},
                {data: 'name', name: 'name'},
                {data: 'locations', name: 'locations', 'searchable': false, 'orderable': false,
                    render: function(data, type, full, meta) {
                        return '<span data-toggle="tooltip" title="'+full.locations_title+'">'+data+'</span>';
                    }
                },
                {data: 'type', name: 'type', 'searchable': false, 'orderable': false},
                {data: 'waiting', name: 'type', 'orderable': false},
                {data: 'project', name: 'project'},
                {data: 'notes', name: 'notes'},
				{data: 'first_name', 'visible' : false},
				{data: 'last_name', 'visible' : false},
                {data: 'locations_title', 'visible' : false},
			],
			processing: true,
			language: {
				processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
			},

			ajax: {
				url: url,
				data: function (d) {
					d.property = $(".prop_select").val()
				},
			},
			buttons: [
				"copy","csv","excel","pdf","print","colvis",
				{
					text: 'Add user',
					action: function ( e, dt, node, config ) {
						window.location.href = '{{ route('user.create') }}';
					}
				}
			],
			order: [[ 0, "desc" ]],
			'createdRow': function( row, data, dataIndex ) {
				if(data.email_verified_at) {
					$(row).addClass('email_verified');
				}
				else {
					$(row).addClass('email_not_verified');
				}
			}
		};
		table = $("#table1").DataTable(initTable);
	}
	InitializeTable('{{ route('api.users') }}');

	$("#table1 tbody").on('click', 'tr', function(e){
		var data = table.row( this ).data();
		window.location.href = '/users/view/'+data.id;
	});
	$(".prop_select").on('change', function(){
		table.rows().remove();
		$("#table1").dataTable().fnDestroy();
        InitializeTable('{{ route('api.users') }}');
	});
});
</script>
@endpush
@endsection
