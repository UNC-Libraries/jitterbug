       <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[filmElement]', 'Element', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('itemable[filmElement]', null, array('id' => 'film-element', 'class' => 'form-control form-control-sm', 'placeholder' => 'e.g. Negative')) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('itemable.filmBase')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[filmBase]', 'Base', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('itemable[filmBase]', null, array('id' => 'film-base', 'class' => 'form-control form-control-sm', 'placeholder' => 'e.g. Polyester')) !!}
            @if ($errors->has('itemable.filmBase'))
              <div class="form-control-label"><small>{!! $errors->first('itemable.filmBase') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[filmColor]', 'Color', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('itemable[filmColor]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. B/W')) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[soundType]', 'Sound Type', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            @if (!$item->batch() || $item->itemable->soundType !== '<mixed>')
              {!! Form::select('itemable[soundType]',
                array('' => 'Select a type', 'Magnetic' => 'Magnetic', 'Optical' => 'Optical', 'Silent' => 'Silent'), $item->itemable == null ? null : $item->itemable->soundType, array('class' => 'form-control form-control-sm')) !!}
            @else
              {!! Form::select('itemable[soundType]',
                array('' => 'Select a type', '<mixed>' => '<mixed>', 'Magnetic' => 'Magnetic', 'Optical' => 'Optical', 'Silent' => 'Silent'), $item->itemable == null ? null : $item->itemable->soundType, array('class' => 'form-control form-control-sm')) !!}
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('itemable.lengthInFeet')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[lengthInFeet]', 'Length in Feet', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('itemable[lengthInFeet]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. 400')) !!}
            @if ($errors->has('itemable.lengthInFeet'))
              <div class="form-control-label"><small>{!! $errors->first('itemable.lengthInFeet') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[filmStock]', 'Film Stock', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('itemable[filmStock]', null, array('class' => 'form-control form-control-sm')) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[edgeCode]', 'Edge Code', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('itemable[edgeCode]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. Triangle, Triangle')) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[shrinkagePercent]', 'Shrinkage Percent', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('itemable[shrinkagePercent]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. .08')) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('itemable.canNumber')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[canNumber]', 'Can Number', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('itemable[canNumber]', null, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('itemable.canNumber'))
              <div class="form-control-label"><small>{!! $errors->first('itemable.canNumber') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('itemable[filmContentDescription]', 'Content Description', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::textarea('itemable[filmContentDescription]', null, array('class' => 'form-control form-control-sm', 'rows' => 3)) !!}
          </div>
        </div>
      </div>