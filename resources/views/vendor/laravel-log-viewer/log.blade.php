@extends('layouts.app')

@section('template_title')
  Log Information
@endsection

@section('template_linked_css')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
@endsection

@section('content')
  <div class="container-fluid logs-container">
    <div class="row">
      <div class="col-sm-3 col-md-2 sidebar">
        <h4><span class="fa fa-fw fa-file-code-o" aria-hidden="true"></span> Log Files</h4>
        <div class="list-group">
          @foreach($files as $file)
            <a href="?l={{ base64_encode($file) }}" class="list-group-item @if ($current_file == $file) llv-active @endif">
              {{$file}}
              @if ($current_file == $file)
                <span class="badge pull-right">
                  {{ count($logs) }}
                </span>
              @endif
            </a>
          @endforeach
        </div>
      </div>
      <div class="col-sm-9 col-md-10 table-container">
        @if ($logs === null)
          <div>
            Log file >50M, please download it.
          </div>
        @else
        <table id="table-log" class="table table-striped">
          <thead>
            <tr>
              <th>Level</th>
              <th>Context</th>
              <th>Date</th>
              <th>Content</th>
            </tr>
          </thead>
          <tbody>
            @foreach($logs as $key => $log)
            <tr>
              <td class="text-{{{$log['level_class']}}}"><span class="glyphicon glyphicon-{{{$log['level_img']}}}-sign" aria-hidden="true"></span> &nbsp;{{$log['level']}}</td>
              <td class="text">{{$log['context']}}</td>
              <td class="date">{{{$log['date']}}}</td>
              <td class="text">
                @if ($log['stack']) <a class="pull-right expand btn btn-default btn-xs" data-display="stack{{{$key}}}"><span class="glyphicon glyphicon-search"></span></a>@endif
                {{{$log['text']}}}
                @if (isset($log['in_file'])) <br />{{{$log['in_file']}}}@endif
                @if ($log['stack']) <div class="stack" id="stack{{{$key}}}" style="display: none; white-space: pre-wrap;">{{{ trim($log['stack']) }}}</div>@endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @endif
        <div>
          @if($current_file)
            <a href="?dl={{ base64_encode($current_file) }}"><span class="glyphicon glyphicon-download-alt"></span> Download file</a>
            -
            <a id="delete-log" data-toggle="modal" data-target="#confirmDelete" data-href="?del={{ base64_encode($current_file) }}" data-title="Delete Log File" data-message="Are you sure you want to delete log file?"><span class="glyphicon glyphicon-trash"></span> Delete file</a>
            @if(count($files) > 1)
              -
              <a id="delete-all-log" data-toggle="modal" data-target="#confirmDelete" data-href="?delall=true" data-title="Delete All Log Files" data-message="Are you sure you want to delete all log files?"><span class="glyphicon glyphicon-trash"></span> Delete all files</a>
            @endif
          @endif
        </div>
      </div>
    </div>
  </div>
  @include('modals.modal-delete')
@endsection

@section('footer_scripts')
  @include('scripts.datatables')
  <script>
    $(document).ready(function(){
      $('#table-log').DataTable({
        "order": [ 1, 'desc' ],
        "stateSave": true,
        "stateSaveCallback": function (settings, data) {
          window.localStorage.setItem("datatable", JSON.stringify(data));
        },
        "stateLoadCallback": function (settings) {
          var data = JSON.parse(window.localStorage.getItem("datatable"));
          if (data) data.start = 0;
          return data;
        }
      });

      $('.table-container').on('click', '.expand', function(){
        $('#' + $(this).data('display')).toggle();
      });

      // Delete Logs Modal
      $('#confirmDelete').on('show.bs.modal', function (e) {
        var message = $(e.relatedTarget).attr('data-message');
        var title = $(e.relatedTarget).attr('data-title');
        var href = $(e.relatedTarget).attr('data-href');
        $(this).find('.modal-body p').text(message);
        $(this).find('.modal-title').text(title);
        $(this).find('.modal-footer #confirm').data('href', href);
      });
      $('#confirmDelete').find('.modal-footer #confirm').on('click', function(){
        window.location = $(this).data('href');
      });
    });
  </script>
@endsection