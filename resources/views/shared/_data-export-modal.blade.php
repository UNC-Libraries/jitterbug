      {!! Form::open(array('route' => $route, 'id' => 'data-export-form')) !!}
      <div id="data-export-modal" class="modal fade" tabindex="-1" role="dialog">
        <div id="data-export-dialog" class="modal-dialog modal-sm">
          <div id="data-export-dialog-content" class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">{{$title}}</h4>
            </div>
            <div class="modal-body export-modal-body">
              <div class="centered"><i id="loading-export-fields-spinner" class="fa fa-spinner fa-pulse export-spinner" style="display: none;"></i></div>
              <div id="data-export-fields-container"></div>
            </div>
            <div class="modal-footer">
              <div>
                {!! Form::hidden('ids') !!}
                <button name="exportCommand" value="execute" type="submit" class="btn btn-sm btn-primary" style="outline: none; margin-right: .5rem"><i class="fa fa-download" aria-hidden="true"></i> Build and Download</button>
                <i id="export-building-spinner" class="fa fa-spinner fa-pulse export-spinner" style="display: none;"></i>
              </div>
            </div>

          </div>
        </div>
      </div>
      {!! Form::close() !!}