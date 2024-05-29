      {{-- FilmItem fields --}}
       <div class="row">
        <div class="form-group @if ($errors->has('subclass.film_element')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('Element', 'subclass[film_element]')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('subclass[film_element]')->id('film-element')->class('form-control form-control-sm')->placeholder('e.g. Negative') }}
            @if ($errors->has('subclass.film_element'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.film_element') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.film_base')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('Base', 'subclass[film_base]')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('subclass[film_base]')->id('film-base')->class('form-control form-control-sm')->placeholder('e.g. Polyester') }}
            @if ($errors->has('subclass.film_base'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.film_base') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.film_color')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('Color', 'subclass[film_color]')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('subclass[film_color]')->class('form-control form-control-sm')->placeholder('e.g. B/W') }}
            @if ($errors->has('subclass.film_color'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.film_color') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {{ html()->label('Sound Type', 'subclass[sound_type]')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            @if (!$item->batch() || $item->subclass->sound_type !== '<mixed>')
              {{ html()->select('subclass[sound_type]', array('' => 'Select a type', 'Magnetic' => 'Magnetic', 'Optical' => 'Optical', 'Magnetic; Optical' => 'Magnetic; Optical', 'Silent' => 'Silent'), $item->subclass == null ? null : $item->subclass->sound_type)->class('form-control form-control-sm') }}
            @else
              {{ html()->select('subclass[sound_type]', array('' => 'Select a type', '<mixed>' => '<mixed>', 'Magnetic' => 'Magnetic', 'Optical' => 'Optical', 'Magnetic; Optical' => 'Magnetic; Optical', 'Silent' => 'Silent'), $item->subclass == null ? null : $item->subclass->sound_type)->class('form-control form-control-sm') }}
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.length_in_feet')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('Length in Feet', 'subclass[length_in_feet]')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('subclass[length_in_feet]')->class('form-control form-control-sm')->placeholder('e.g. 400') }}
            @if ($errors->has('subclass.length_in_feet'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.length_in_feet') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.film_stock')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('Film Stock', 'subclass[film_stock]')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('subclass[film_stock]')->class('form-control form-control-sm') }}
            @if ($errors->has('subclass.film_stock'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.film_stock') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.edge_code')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('Edge Code', 'subclass[edge_code]')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('subclass[edge_code]')->class('form-control form-control-sm')->placeholder('e.g. Triangle, Triangle') }}
            @if ($errors->has('subclass.edge_code'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.edge_code') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.shrinkage_percent')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('Shrinkage Percent', 'subclass[shrinkage_percent]')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('subclass[shrinkage_percent]')->class('form-control form-control-sm')->placeholder('e.g. .08') }}
            @if ($errors->has('subclass.shrinkage_percent'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.shrinkage_percent') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.can_number')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('Can Number', 'subclass[can_number]')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('subclass[can_number]')->class('form-control form-control-sm') }}
            @if ($errors->has('subclass.can_number'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.can_number') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.condition')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('Condition', 'subclass[condition]')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->text('subclass[condition]')->class('form-control form-control-sm') }}
            @if ($errors->has('subclass.condition'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.condition') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.film_content_description')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {{ html()->label('Content Description', 'subclass[film_content_description]')->class('form-control-label') }}
          </div>
          <div class="col-xs-7 detail-value">
            {{ html()->textarea('subclass[film_content_description]')->class('form-control form-control-sm')->rows(3) }}
            @if ($errors->has('subclass.film_content_description'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.film_content_description') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      {{-- End FilmItem fields --}}