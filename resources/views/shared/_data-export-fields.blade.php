              <div id="data-export-fields-container">
                <div id="export-instructions">Choose from the fields below to customize your export.</div>
                <hr>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="row">
                      <div class="col-sm-6">
                        @foreach ($fields[0] as $label => $field)
                        <div>
                          <label>
                            <input type="checkbox" name="fields[]" value="{{$field}}" class="checkSingle">
                            {{$label}}
                          </label>
                        </div>
                        @endforeach
                      </div>
                      <div class="col-sm-6">
                        @foreach ($fields[1] as $label => $field)
                        <div>
                          <label>
                            <input type="checkbox" name="fields[]" value="{{$field}}" class="checkSingle">
                            {{$label}}
                          </label>
                        </div>
                        @endforeach
                        <div>
                          <label>
                            <input type="checkbox" name="checkAll" id="checkedAll" value="selectAll">
                            Select All
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>