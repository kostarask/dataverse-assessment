<div class="table-responsive">
    <table id="roles-table" class="table table-striped table-vmiddle table-bordered">
        @foreach($roles as $role)
            <tr>
                <td>{{ __($role) }}</td>
            </tr>
        @endforeach
    </table>
</div>
