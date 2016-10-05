       <div class="row">
        <div class="form-group @if ($errors->has('subclass.filmElement')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[filmElement]', 'Element', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[filmElement]', null, array('id' => 'film-element', 'class' => 'form-control form-control-sm', 'placeholder' => 'e.g. Negative')) !!}
            @if ($errors->has('subclass.filmElement'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.filmElement') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.filmBase')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[filmBase]', 'Base', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[filmBase]', null, array('id' => 'film-base', 'class' => 'form-control form-control-sm', 'placeholder' => 'e.g. Polyester')) !!}
            @if ($errors->has('subclass.filmBase'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.filmBase') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.filmColor')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[filmColor]', 'Color', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[filmColor]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. B/W')) !!}
            @if ($errors->has('subclass.filmColor'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.filmColor') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[soundType]', 'Sound Type', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            @if (!$item->batch() || $item->subclass->soundType !== '<mixed>')
              {!! Form::select('subclass[soundType]',
                array('' => 'Select a type', 'Magnetic' => 'Magnetic', 'Optical' => 'Optical', 'Silent' => 'Silent'), $item->subclass == null ? null : $item->subclass->soundType, array('class' => 'form-control form-control-sm')) !!}
            @else
              {!! Form::select('subclass[soundType]',
                array('' => 'Select a type', '<mixed>' => '<mixed>', 'Magnetic' => 'Magnetic', 'Optical' => 'Optical', 'Silent' => 'Silent'), $item->subclass == null ? null : $item->subclass->soundType, array('class' => 'form-control form-control-sm')) !!}
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.lengthInFeet')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[lengthInFeet]', 'Length in Feet', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[lengthInFeet]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. 400')) !!}
            @if ($errors->has('subclass.lengthInFeet'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.lengthInFeet') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.filmStock')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[filmStock]', 'Film Stock', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[filmStock]', null, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('subclass.filmStock'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.filmStock') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.edgeCode')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[edgeCode]', 'Edge Code', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[edgeCode]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. Triangle, Triangle')) !!}
            @if ($errors->has('subclass.edgeCode'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.edgeCode') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.shrinkagePercent')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[shrinkagePercent]', 'Shrinkage Percent', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[shrinkagePercent]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. .08')) !!}
            @if ($errors->has('subclass.shrinkagePercent'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.shrinkagePercent') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.canNumber')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[canNumber]', 'Can Number', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[canNumber]', null, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('subclass.canNumber'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.canNumber') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.filmContentDescription')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[filmContentDescription]', 'Content Description', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::textarea('subclass[filmContentDescription]', null, array('class' => 'form-control form-control-sm', 'rows' => 3)) !!}
            @if ($errors->has('subclass.filmContentDescription'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.filmContentDescription') !!}</small></div>
            @endif
          </div>
        </div>
      </div>