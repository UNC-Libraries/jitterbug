      <div id="{{$type}}-import-modal" class="modal fade" tabindex="-1" role="dialog">
        <div id="{{$type}}-import-dialog" class="modal-dialog modal-sm">
          <div id="{{$type}}-import-dialog-content" class="modal-content">

            <div id="{{$type}}-import-step-1">
              {!! Form::open(array('route' => "transfers.$type.import.upload", 'files' => true, 'id' => "$type-upload-form")) !!}
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">{{title_case($type)}} Import - Step 1 of 3</h4>
              </div>
              <div class="modal-body import-modal-body">
                <div class="file-select-label">File to Import (.csv, UTF-8, quoted text)</div>
                <div class="input-group">
                  <span class="input-group-btn">
                    <label class="btn btn-sm btn-secondary btn-file-select">Browse<input id="{{$type}}-import-file" name="{{$type}}-import-file" type="file" style="display: none;">
                    </label>
                  </span>
                  <input id="{{$type}}-import-filename" type="text" class="form-control form-control-sm" placeholder="No file selected" style="background-color: #fff" readonly>
                </div>
                <div id="{{$type}}-upload-form-error" class="text-danger upload-form-error"></div>
              </div>
              <div class="modal-footer">
                <button name="upload" type="submit" class="btn btn-sm btn-secondary" style="outline: none;"><i class="fa fa-upload" aria-hidden="true"></i> Upload and Continue</button>
                <i id="{{$type}}-upload-spinner" class="fa fa-spinner fa-pulse import-spinner" style="display: none;"></i>
              </div>
              {!! Form::close() !!}
            </div>

            <div id="{{$type}}-import-step-2" style="display: none;">
              {!! Form::open(array('route' => "transfers.$type.import.execute", 'id' => "$type-import-form")) !!}
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">{{title_case($type)}} Import - Step 2 of 3</h4>
              </div>
              <div class="modal-body import-modal-body">
                <div id="{{$type}}-upload-data-container"></div>
              </div>
              <div class="modal-footer">
                <div class="success-actions">
                  <button name="import" type="submit" class="btn btn-sm btn-primary" style="outline: none; margin-right: .5rem"><i class="fa fa-bolt" aria-hidden="true"></i> Proceed with Import</button><a class="reset" href="#">or Start Over</a><i id="{{$type}}-import-spinner" class="fa fa-spinner fa-pulse import-spinner" style="display: none;"></i>
                </div>
                <div class="failure-actions" style="display: none;">
                  <button type="submit" class="btn btn-sm btn-secondary reset" style="outline: none;"> Start Over</button>
                </div>
              </div>
              {!! Form::close() !!}
            </div>

            <div id="{{$type}}-import-step-3" style="display: none;">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">{{title_case($type)}} Import - Step 3 of 3</h4>
              </div>
              <div class="modal-body import-modal-body">
                <div id="{{$type}}-import-result-container"></div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-secondary reset" style="outline: none;"> Start Over</button>
              </div>
            </div>

          </div>
        </div>
      </div>
