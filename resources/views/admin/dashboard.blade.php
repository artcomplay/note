@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                    <!--<div>
                        <canvas id="myChart"></canvas>
                    </div>-->


                    <nav class="dash-vertical-menu">
                    <i class="fa fa-search search-input-i" aria-hidden="true"></i><input id="search-element" class="search-input form-control" placeholder="Поиск по сайту" type="text" name="search">
                    <div><ul class="result-search"></ul></div>
                        <ul class="elements">
                            @foreach($elements as $element)
                                <li id="el-id-{{ $element->id }}">
                                    <a class="section-href" href="" onclick="elementData(event, '{{ $element->id }}')">{{ $element->element_name }}</a><i title="Удалить раздел {{ $element->element_name }}" onclick="getRemoveElements(event, '{{ $element->id }}')" class="fa fa-times remove-element" aria-hidden="true"></i><i title="Редактировать раздел {{ $element->element_name }}" onclick="inputEditID('{{ $element->id }}')" class="fa fa-pencil-square-o edit-element" aria-hidden="true" data-toggle="modal" data-target=".bd-edit-modal-lg"></i><i title="Создать элемент для раздела {{ $element->element_name }}" onclick="inputID('{{ $element->complex_id }}')" class="fa fa-sun-o new-element" aria-hidden="true" data-toggle="modal" data-target=".bd-child-modal-lg"></i>
                                    <ul class="elements" id="element-id-{{ $element->id }}"></ul>
                                </li>
                            @endforeach

                            <li><i class="fa fa-plus-circle create-section-icon" aria-hidden="true"></i><a data-toggle="modal" data-target=".bd-example-modal-lg" >Добавить раздел</a></li>
                            <li><i class="fa fa-puzzle-piece all-attribute" aria-hidden="true"></i><a onclick="getAllAttributes(event)" >Все атрибуты</a></li>
                            <table class="table-attr-main">
                                <thead>
                                    <tr class="table-attr"><th style="width: 20%;">Название элемента</th><th style="width: 15%;">Название атрибута</th><th style="width: 15%;">Описание</th><th style="width: 3%;">Изображение</th><th style="width: 10%;">Целое число</th><th style="width: 10%;">Дробное x.2</th><th style="width: 10%;">Дробное x.15</th><th style="width: 2%;">Истина/Ложь</th><th style="width: 10%;">Дата создания</th><th style="width: 10%;">Дата обновления</th></tr>
                                </thead>
                                <tbody></tbody>
                            </table>

                        </ul>

                    </nav>


                </div>

                <!--<div class="main-block-section col-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
                    <body>
                        <div class="warning-block"></div>
                        <ul class="categories">

                        </ul>
                    </body>
                </div>-->



                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>

                                        <div class="input-create-element">
                                            <input type="text" class="element-name form-control clear-input" onkeypress="btnEnter(event, 'section')" name="element-name" placeholder="Название раздела">
                                            <input type="submit" class="btn btn-success" id="cr-sec" data-dismiss="modal" aria-label="Close" onclick="createNote(event, null)" value="Создать раздел">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade bd-child-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>

                                        <div class="input-create-element">
                                            <input type="text" class="element-name-complex form-control clear-input" onkeypress="btnEnter(event, 'element')"  name="element-name" placeholder="Название элемента">
                                            <input type="submit" class="btn btn-success create-child" id="cr-el" data-dismiss="modal" aria-label="Close" onclick="createNote(event, id)" value="Создать элемент">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade bd-edit-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>

                                        <div class="input-create-element">
                                            <input type="text" class="element-edit-name form-control clear-input" onkeypress="btnEnter(event, 'edit-element')" name="element-name" placeholder="Новое название элемента">
                                            <input type="submit" class="btn btn-success edit-element edit-element-btn" data-dismiss="modal" aria-label="Close" onclick="editElement(event, id)" value="Изменить">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade bd-img-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <div class="big-img-attr"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade bd-attr-edit-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <div class="input-edit-attr">
                                            <input class="element-attr-name form-control clear-input" onkeypress="btnEnter(event, 'edit-attr')" placeholder="Новое название Атрибута" type="text" name="attribute-name"/>
                                            <input class="element-attr-name form-control clear-input" onkeypress="btnEnter(event, 'edit-attr')" placeholder="Новое описание" type="text" name="description"/>
                                            <input type="submit" class="btn btn-success edit-attr-btn" data-dismiss="modal" aria-label="Close" onclick="editAttr(event, id)" value="Изменить атрибут">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade bd-attr-edit-value-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <div class="input-edit-value-attr">
                                            <span class="span-attribute">Значение Атрибута (Целое число)</span>
                                            <input class="element-attr-name form-control clear-input" onkeypress="btnEnter(event, 'edit-val-attr')" placeholder="Номинальное значение" type="number" name="number-attribute"/>
                                            <span class="span-attribute">Значение Атрибута (Дробное число - точность 2 после запятой)</span>
                                            <input class="element-attr-name form-control clear-input" onkeypress="btnEnter(event, 'edit-val-attr')" placeholder="Номинальное значение" type="number" name="double-2"/>
                                            <span class="span-attribute">Значение Атрибута (Дробное число - точность 15 после запятой)</span>
                                            <input class="element-attr-name form-control clear-input" onkeypress="btnEnter(event, 'edit-val-attr')" placeholder="Номинальное значение" type="number" name="double-15"/>
                                            <span class="span-attribute">Время начала</span>
                                            <input class="element-attr-name form-control clear-input" onkeypress="btnEnter(event, 'edit-val-attr')" placeholder="Время" type="time" name="time-first"/>
                                            <span class="span-attribute">Время окончания</span>
                                            <input class="element-attr-name form-control clear-input" onkeypress="btnEnter(event, 'edit-val-attr')" placeholder="Время" type="time" name="time-second"/>
                                            <span class="span-attribute">Текст Атрибута</span>
                                            <textarea class="element-attr-name form-control clear-input" onkeypress="btnEnter(event, 'edit-val-attr')" placeholder="Текст" type="text" name="attribute-text"></textarea>
                                            <span class="span-attribute">Ссылка на источник</span>
                                            <input class="element-attr-name form-control clear-input" onkeypress="btnEnter(event, 'edit-val-attr')" placeholder="https://www.source.com" type="text" name="attribute-varchar"/>
                                            <input class="element-attr-name form-control file-input clear-input" onkeypress="btnEnter(event, 'edit-val-attr')" onchange="encodeImageEdit(this)" type="file" name="attribute-file"/>
                                            <a class="link-edit"></a>
                                            <span class="span-attribute">Да</span>
                                            <input class="element-attr-name form-control input-radio-attribute radio-unchecked" onkeypress="btnEnter(event, 'edit-val-attr')" type="radio" name="attribute-bool" value="1" />
                                            <span class="span-attribute">Нет</span>
                                            <input class="element-attr-name form-control input-radio-attribute radio-unchecked" onkeypress="btnEnter(event, 'edit-val-attr')" type="radio" name="attribute-bool" value="0"/>
                                            <span class="span-attribute">Пусто</span>
                                            <input class="element-attr-name form-control input-radio-attribute radio-checked" onkeypress="btnEnter(event, 'edit-val-attr')" type="radio" name="attribute-bool" value="" checked/>
                                            <input class="element-attr-name form-control clear-input" placeholder="IP адрес" onkeypress="btnEnter(event, 'edit-val-attr')" type="text" name="attribute-ip"/>
                                            <input class="element-attr-name form-control attr-id" onkeypress="btnEnter(event, 'edit-val-attr')" type="text" name="attrubute-id"/>
                                            <input type="submit" class="btn btn-success edit-val-attr-element" data-dismiss="modal" aria-label="Close" onclick="editValueAttr(event, id)" value="Изменить атрибут">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade bd-attr-create-val-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <div class="input-create-value-attr">
                                            <span class="span-attribute">Значение Атрибута (Целое число)</span>
                                            <input class="element-attr-name form-control clear-input" onkeypress="btnEnter(event, 'cr-attr-val')" placeholder="Номинальное значение" type="number" name="number-attribute"/>
                                            <span class="span-attribute">Значение Атрибута (Дробное число - точность 2 после запятой)</span>
                                            <input class="element-attr-name form-control clear-input" onkeypress="btnEnter(event, 'cr-attr-val')" placeholder="Номинальное значение" type="number" name="double-2"/>
                                            <span class="span-attribute">Значение Атрибута (Дробное число - точность 15 после запятой)</span>
                                            <input class="element-attr-name form-control clear-input" onkeypress="btnEnter(event, 'cr-attr-val')" placeholder="Номинальное значение" type="number" name="double-15"/>
                                            <span class="span-attribute">Время начала</span>
                                            <input class="element-attr-name form-control clear-input" onkeypress="btnEnter(event, 'cr-attr-val')" placeholder="Время" type="time" name="time-first"/>
                                            <span class="span-attribute">Время окончания</span>
                                            <input class="element-attr-name form-control clear-input" onkeypress="btnEnter(event, 'cr-attr-val')" placeholder="Время" type="time" name="time-second"/>
                                            <span class="span-attribute">Текст Атрибута</span>
                                            <textarea class="element-attr-name form-control clear-input" onkeypress="btnEnter(event, 'cr-attr-val')" placeholder="Текст" type="text" name="attribute-text"></textarea>
                                            <span class="span-attribute">Ссылка на источник</span>
                                            <input class="element-attr-name form-control clear-input" onkeypress="btnEnter(event, 'cr-attr-val')" placeholder="https://www.source.com" type="text" name="attribute-varchar"/>
                                            <input class="element-attr-name form-control file-input clear-input" onkeypress="btnEnter(event, 'cr-attr-val')" onchange="encodeImage(this)" type="file" name="attribute-file"/>
                                            <a class="link"></a>
                                            <span class="span-attribute">Да</span>
                                            <input class="element-attr-name form-control input-radio-attribute radio-unchecked" onkeypress="btnEnter(event, 'cr-attr-val')" type="radio" name="attribute-bool" value="1" />
                                            <span class="span-attribute">Нет</span>
                                            <input class="element-attr-name form-control input-radio-attribute radio-unchecked" onkeypress="btnEnter(event, 'cr-attr-val')" type="radio" name="attribute-bool" value="0"/>
                                            <span class="span-attribute">Пусто</span>
                                            <input class="element-attr-name form-control input-radio-attribute radio-checked" onkeypress="btnEnter(event, 'cr-attr-val')" type="radio" name="attribute-bool" value="" checked/>
                                            <input class="element-attr-name form-control clear-input" placeholder="IP адрес" onkeypress="btnEnter(event, 'cr-attr-val')" type="text" name="attribute-ip"/>
                                            <input class="element-attr-name form-control attr-id" onkeypress="btnEnter(event, 'cr-attr-val')" type="text" name="attrubute-id"/>
                                            <input type="submit" class="btn btn-success create-val-attr-element" data-dismiss="modal" aria-label="Close" onclick="createAttributeValue(event, id)" value="Создать атрибут">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade bd-attr-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <div class="input-create-attr-element">
                                            <span class="span-attribute">Название атрибута</span>
                                            <input class="element-attr-name form-control clear-input" onkeypress="btnEnter(event, 'attr-element')" placeholder="Название Атрибута" type="text" name="attribute-name"/>
                                            <span class="span-attribute">Описание Атрибута</span>
                                            <input class="element-attr-name form-control clear-input" onkeypress="btnEnter(event, 'attr-element')" placeholder="Описание" type="text" name="description"/>
                                            <span class="span-attribute">Значение Атрибута (Целое число)</span>
                                            <input class="element-attr-name form-control clear-input" onkeypress="btnEnter(event, 'attr-element')" placeholder="Номинальное значение" type="number" name="number-attribute"/>
                                            <span class="span-attribute">Значение Атрибута (Дробное число - точность 2 после запятой)</span>
                                            <input class="element-attr-name form-control clear-input" onkeypress="btnEnter(event, 'attr-element')" placeholder="Номинальное значение" type="number" name="double-2"/>
                                            <span class="span-attribute">Значение Атрибута (Дробное число - точность 15 после запятой)</span>
                                            <input class="element-attr-name form-control clear-input" onkeypress="btnEnter(event, 'attr-element')" placeholder="Номинальное значение" type="number" name="double-15"/>
                                            <span class="span-attribute">Время начала</span>
                                            <input class="element-attr-name form-control clear-input" onkeypress="btnEnter(event, 'attr-element')" placeholder="Время" type="time" name="time-first"/>
                                            <span class="span-attribute">Время окончания</span>
                                            <input class="element-attr-name form-control clear-input" onkeypress="btnEnter(event, 'attr-element')" placeholder="Время" type="time" name="time-second"/>
                                            <span class="span-attribute">Текст Атрибута</span>
                                            <textarea class="element-attr-name form-control clear-input" onkeypress="btnEnter(event, 'attr-element')" placeholder="Текст" type="text" name="attribute-text"></textarea>
                                            <span class="span-attribute">Ссылка на источник</span>
                                            <input class="element-attr-name form-control clear-input" onkeypress="btnEnter(event, 'attr-element')" placeholder="https://www.source.com" type="text" name="attribute-varchar"/>
                                            <input class="element-attr-name form-control file-input clear-input" onkeypress="btnEnter(event, 'attr-element')" onchange="encodeImage(this)" type="file" name="attribute-file"/>
                                            <a class="link"></a>
                                            <span class="span-attribute">Да</span>
                                            <input class="element-attr-name form-control input-radio-attribute radio-unchecked" onkeypress="btnEnter(event, 'attr-element')" type="radio" name="attribute-bool" value="1" />
                                            <span class="span-attribute">Нет</span>
                                            <input class="element-attr-name form-control input-radio-attribute radio-unchecked" onkeypress="btnEnter(event, 'attr-element')" type="radio" name="attribute-bool" value="0"/>
                                            <span class="span-attribute">Пусто</span>
                                            <input class="element-attr-name form-control input-radio-attribute radio-checked" onkeypress="btnEnter(event, 'attr-element')" type="radio" name="attribute-bool" value="" checked/>
                                            <input class="element-attr-name form-control clear-input" onkeypress="btnEnter(event, 'attr-element')" placeholder="IP адрес" type="text" name="attribute-ip"/>
                                            <input class="element-attr-name form-control attr-id" onkeypress="btnEnter(event, 'attr-element')" type="text" name="attrubute-id"/>
                                            <input type="submit" class="btn btn-success attr-element" data-dismiss="modal" aria-label="Close" onclick="createAttr(event, id)" value="Создать атрибут">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('custom_js')
 <script>

    function btnEnter(event, type){
        if (event.keyCode === 13) {
            console.log(type);
            if(type == 'section'){
                $('#cr-sec').trigger('click');
            } else if(type == 'element'){
                $('.create-child').trigger('click');
            } else if(type == 'edit-element'){
                $('.edit-element-btn').trigger('click');
            } else if(type == 'edit-attr'){
                $('.edit-attr-btn').trigger('click');
            } else if(type == 'attr-element'){
                $('.attr-element').trigger('click');
            } else if(type == 'cr-attr-val'){
                $('.create-val-attr-element').trigger('click');
            } else if(type == 'edit-val-attr'){
                $('.edit-val-attr-element').trigger('click');
            }
        }
    }

    function getAttrVal(attrID){
        $.ajax({
            url: "{{ route('admin.get_attr_val') }}",
            type: 'GET',
            data: {
                attribute_id: attrID,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                if(data.length != 0){
                    for(let i = 0; i < data.length; i++){

                        if(data[i].attribute_img != null){
                            $('#tabl-attr-id-' + data[i].attribute_id).children('.table-attr-img').append('<img src="' + data[i].attribute_img + '" />');
                        }
                        if(data[i].attribute_int != null){
                            $('#tabl-attr-id-' + data[i].attribute_id).children('.table-attr-int').children('ul').append('<li>' + data[i].attribute_int + '</li>');
                        }
                        if(data[i].attribute_float != null){
                            if(i == 0){
                                $('#tabl-attr-id-' + data[i].attribute_id).children('.table-attr-d2').children('ul').append('<i class="fa fa-bar-chart chart-style" aria-hidden="true"></i>');
                            }
                            $('#tabl-attr-id-' + data[i].attribute_id).children('.table-attr-d2').children('ul').append('<li>' + data[i].attribute_float + '</li>');
                        }
                        if(data[i].attribute_double != null){
                            $('#tabl-attr-id-' + data[i].attribute_id).children('.table-attr-d15').children('ul').append('<li>' + data[i].attribute_double + '</li>');
                        }
                        if(data[i].attribute_bool != null){
                            if(data[i].attribute_bool == 1){
                                $('#tabl-attr-id-' + data[i].attribute_id).children('.table-attr-bool').append('<li><i class="fa fa-check-circle bool-icon-true" aria-hidden="true"></i></li>');
                            } else if(data[i].attribute_bool == 0){
                                $('#tabl-attr-id-' + data[i].attribute_id).children('.table-attr-bool').append('<li><i class="fa fa-times-circle bool-icon-false" aria-hidden="true"></i></li>');
                            }
                        }
                    }
                }
            }
        })
    }

    function getAllAttributes(event){
        event.preventDefault();
        let td = $('.table-attr').children('td');
        let disp = $('.table-attr-main').css('display');
        if(td.length != 0 && disp == 'none'){
            $('.table-attr-main').show();
        } else if(td.length == 0 && disp == 'none'){
            $('.table-attr-main').show();
            $.ajax({
                url: "{{ route('admin.get_all_attr') }}",
                type: 'GET',
                data: {},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {
                    if(data.length != 0){
                        for(let i = 0; i < data.length; i++){
                            let desc = '';
                            if(data[i].attribute_description != null){
                                desc = data[i].attribute_description
                            } else {
                                desc = '';
                            }
                            $('.table-attr-main').children('tbody').append('<tr id="tabl-attr-id-' + data[i].id + '" class="table-attr"> <td class="table-el-name" onclick="getComplexID(event, ' + data[i].element_id + ')">' + data[i].element_name + '</td> <td><a>' + data[i].attribute_name + '</a></td> <td>' + desc + '</td> <td class="table-attr-img"></td>  <td class="table-attr-int"><ul></ul></td>  <td class="table-attr-d2"><ul></ul></td>  <td class="table-attr-d15"><ul></ul></td>  <td class="table-attr-bool"></td>  <td>' + data[i].created_at + '</td>  <td>' + data[i].updated_at + '</td> </tr>');
                            getAttrVal(data[i].id);
                            //let complexID = getComplexID(event, data[i].element_id);
                            //console.log(complexID);
                        }
                    }
                }
            })
        } else if(td.length != 0 && disp == 'table'){
            $('.table-attr-main').hide();
        }
    }

    function removeAttribute(attrType, attrID, elementID){
        $.ajax({
            url: "{{ route('admin.remove_attr') }}",
            type: 'POST',
            data: {
                attr_type: attrType,
                attr_id: attrID
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                //elementData(event, elementID);
                getAllAttributes(event);
                let complexID = getComplexID(event, elementID);
            }
        })
    }


    function showResultSearch(event, complexID){
        complexID = complexID.split('-');
        for(let i = 0; i < complexID.length; i++){
            elementDataSearch(event, complexID[i]);
        }
    }

    function removeInputAttr(attrID, elementID){
        let mainAttr = attrID.replace('r-at-main-', '');
        let valAttr = attrID.replace('r-at-', '');
        if(isNaN(Number(mainAttr)) == false){
            removeAttribute('main', mainAttr, elementID);
        }
        if(isNaN(Number(valAttr)) == false){
            removeAttribute('value', valAttr, elementID);
        }
        $('.table-attr-main').children('tbody').empty();
        $('.table-attr-main').hide();
    }



    function createInputAttr(attrID, elementID){
        emptyForms();
        $('.create-val-attr-element').attr('id', 'crt-attr-' + elementID);
        $('.attr-id').attr('value', attrID);
    }

    function editInputAttr(attrID, elementID){
        emptyForms();
        let newAttrID = attrID.replace('e-at-', '');
        $('.edit-attr-btn').attr('id', 'edit-attr-' + newAttrID);
        $('.input-edit-attr').attr('id', 'el-ed-art-' + elementID);
    }

    function editValInputAttr(attrID, elementID, id){
        emptyForms();
        let valAttrID = attrID.replace('e-v-at-', '');
        $('.attr-id').attr('value', id);
        $('.edit-val-attr-element').attr('id', 'e-val-at-' + valAttrID);
        $('.input-edit-value-attr').attr('id', 'el-val-ed-at-' + elementID);
    }

    function editAttr(event, attrID){
        event.preventDefault();
        attrID = attrID.replace('edit-attr-', '');
        let arEdit = $('.input-edit-attr').children('input.form-control');
        let arEditEl = $('.input-edit-attr').attr('id');
        let elementID = arEditEl.replace('el-ed-art-', '');
        $.ajax({
            url: "{{ route('admin.edit_attr') }}",
            type: 'POST',
            data: {
                attrubute_id: attrID,
                attrubute_name: arEdit[0].value,
                attribute_description: arEdit[1].value
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                //elementData(event, elementID);
                $('.table-attr-main').children('tbody').empty();
                $('.table-attr-main').hide();
                let complexID = getComplexID(event, elementID);

            }
        })
    }

    function editValueAttr(event, attrID){
        event.preventDefault();
        attrID = attrID.replace('e-val-at-', '');
        let arEdit = $('.input-edit-value-attr').children('input.form-control');
        let arEditEl = $('.input-edit-value-attr').attr('id');
        let elementID = arEditEl.replace('el-val-ed-at-', '');
        let inputArray = new Array();
        for(let i = 0; i < arEdit.length; i++){
            if(arEdit[i].name == 'attribute-file'){
                let val = $('.link-edit').attr('href');
                inputArray[arEdit[i].name] = val;
            } else if(arEdit[i].name != null && arEdit[i].type != 'submit' && arEdit[i].type != 'radio'){
                inputArray[arEdit[i].name] = arEdit[i].value;
            } else if(arEdit[i].type == 'radio' && arEdit[i].checked == true){
                inputArray[arEdit[i].name] = arEdit[i].value;
            }
        }
        let childText = $('.input-edit-value-attr').children('textarea').val();
        $.ajax({
            url: "{{ route('admin.edit_value_attr') }}",
            type: 'POST',
            data: {
                id: inputArray['attrubute-id'],
                attrubute_id: attrID,
                attribute_bool: inputArray['attribute-bool'],
                attribute_file: inputArray['attribute-file'],
                attribute_ip: inputArray['attribute-ip'],
                attribute_text: childText,
                attribute_varchar: inputArray['attribute-varchar'],
                double_2: inputArray['double-2'],
                double_15: inputArray['double-15'],
                number_attribute: inputArray['number-attribute'],
                time_first: inputArray['time-first'],
                time_second: inputArray['time-second']
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                //elementData(event, elementID);
                $('.table-attr-main').children('tbody').empty();
                $('.table-attr-main').hide();
                let complexID = getComplexID(event, elementID);
            }
        })
    }

    function getComplexID(event, elementID){
        event.preventDefault();
        $.ajax({
            url: "{{ route('admin.get_complex_id') }}",
            type: 'GET',
            data: {
                element_id: elementID
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                if(data.length != 0){
                    for(let i = 0; i < data.length; i++){
                        elementDataSearch(event, data[i]);
                    }
                }
            }
        })
    }

    function createAttr(event, elementID){
        let child = $('.input-create-attr-element').children('input');
        let inputArray = new Array();
        for(let i = 0; i < child.length; i++){
            if(child[i].name == 'attribute-file'){
                let val = $('.link').attr('href');
                inputArray[child[i].name] = val;
            } else if(child[i].name != null && child[i].type != 'submit' && child[i].type != 'radio'){
                inputArray[child[i].name] = child[i].value;
            } else if(child[i].type == 'radio' && child[i].checked == true){
                inputArray[child[i].name] = child[i].value;
            }
        }
        let childText = $('.input-create-attr-element').children('textarea').val();
        $.ajax({
            url: "{{ route('admin.create_attr') }}",
            type: 'POST',
            data: {
                attrubute_id: inputArray['attrubute-id'],
                attribute_bool: inputArray['attribute-bool'],
                attribute_file: inputArray['attribute-file'],
                attribute_ip: inputArray['attribute-ip'],
                attribute_name: inputArray['attribute-name'],
                attribute_text: childText,
                attribute_varchar: inputArray['attribute-varchar'],
                description: inputArray['description'],
                double_2: inputArray['double-2'],
                double_15: inputArray['double-15'],
                number_attribute: inputArray['number-attribute'],
                time_first: inputArray['time-first'],
                time_second: inputArray['time-second']
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                $('.table-attr-main').children('tbody').empty();
                $('.table-attr-main').hide();
                getComplexID(event, elementID);
                //elementData(event, elementID);
            }
        })
    }

    function createAttributeValue(event, elID){
        console.log();
        event.preventDefault();
        let elementID = elID.replace('crt-attr-', '');
        let arEdit = $('.input-create-value-attr').children('input.form-control');
        let arEditEl = $('.input-create-value-attr').attr('id');
        let inputArray = new Array();
        for(let i = 0; i < arEdit.length; i++){
            if(arEdit[i].name == 'attribute-file'){
                let val = $('.link').attr('href');
                inputArray[arEdit[i].name] = val;
            } else if(arEdit[i].name != null && arEdit[i].type != 'submit' && arEdit[i].type != 'radio'){
                inputArray[arEdit[i].name] = arEdit[i].value;
            } else if(arEdit[i].type == 'radio' && arEdit[i].checked == true){
                inputArray[arEdit[i].name] = arEdit[i].value;
            }
        }
        let childText = $('.input-create-value-attr').children('textarea').val();
        let attrID = inputArray['attrubute-id'].replace('crt-attr-', '');
        $.ajax({
            url: "{{ route('admin.create_attr_value') }}",
            type: 'POST',
            data: {
                attrubute_id: attrID,
                attribute_bool: inputArray['attribute-bool'],
                attribute_file: inputArray['attribute-file'],
                attribute_ip: inputArray['attribute-ip'],
                attribute_text: childText,
                attribute_varchar: inputArray['attribute-varchar'],
                double_2: inputArray['double-2'],
                double_15: inputArray['double-15'],
                number_attribute: inputArray['number-attribute'],
                time_first: inputArray['time-first'],
                time_second: inputArray['time-second']
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                getComplexID(event, elementID);
                //elementData(event, elementID);
            }
        })
    }

    function appendBigImg(el){
        let img = $(el).children('img');
        $('.big-img-attr').empty().append('<img class="big-img" src="' + img[0].currentSrc + '" />');
    }

    function attributeData(event, elementID){
        $.ajax({
            url: "{{ route('admin.get_attr') }}",
            type: 'GET',
            data: {
                element_id: elementID
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                if(data.length != 0){
                    for(let i = 0; i < data.length; i++){
                        if(data[i]['attribute_name'] != null){
                            $('#attr-el-' + elementID).append('<div class="attr-container" id="attr-div-' + data[i]['attribute_id'] + '"> <i onclick="createInputAttr(' + data[i]['attribute_id'] + ', ' + elementID + ')" data-target=".bd-attr-create-val-modal-lg" data-toggle="modal" title="Добавить значение для атрибута" class="fa fa-plus-circle value-attr-st" aria-hidden="true"></i> <i title="Удалить атрибут" id="r-at-main-' + data[i]['attribute_id'] + '" onclick="removeInputAttr(id, ' + data[i]['element_id'] + ')" data-toggle="modal" data-target=".bd-attr-remove-modal-lg" class="fa fa-times remove-attr" aria-hidden="true"></i> <i></i> <i  id="e-at-' + data[i]['attribute_id'] + '" onclick="editInputAttr(id, ' + elementID + ')" data-toggle="modal" data-target=".bd-attr-edit-modal-lg" title="Изменить название и описание" class="fa fa-pencil edit-name-attr" aria-hidden="true"></i> <li class="attribute-title"><p>' + data[i]['attribute_name'] + '</p></li>');
                            $('#attr-div-' + data[i]['attribute_id']).append('<div id="desc-attr-' + data[i]['attribute_id'] + '"></div>');
                            $('#attr-div-' + data[i]['attribute_id']).append('<ul id="table-img-' + data[i]['attribute_id'] + '"></ul>');
                            $('#attr-div-' + data[i]['attribute_id']).append('<ul id="table-int-' + data[i]['attribute_id'] + '"></ul>');
                            $('#attr-div-' + data[i]['attribute_id']).append('<ul id="table-float-' + data[i]['attribute_id'] + '"></ul>');
                            $('#attr-div-' + data[i]['attribute_id']).append('<ul id="table-double-' + data[i]['attribute_id'] + '"></ul>');
                            $('#attr-div-' + data[i]['attribute_id']).append('<ul id="table-text-' + data[i]['attribute_id'] + '"></ul>');
                            $('#attr-div-' + data[i]['attribute_id']).append('<ul id="table-varchar-' + data[i]['attribute_id'] + '"></ul>');
                            $('#attr-div-' + data[i]['attribute_id']).append('<ul id="table-time-first-' + data[i]['attribute_id'] + '"></ul>');
                            $('#attr-div-' + data[i]['attribute_id']).append('<ul id="table-time-second-' + data[i]['attribute_id'] + '"></ul>');
                            $('#attr-div-' + data[i]['attribute_id']).append('<ul id="table-bool-' + data[i]['attribute_id'] + '"></ul>');
                            $('#attr-div-' + data[i]['attribute_id']).append('<ul id="table-ip-' + data[i]['attribute_id'] + '"></ul>');
                        }
                        if(data[i]['attribute_description'] != null){
                            $('#desc-attr-' + data[i]['attribute_id']).append('<li class="attribute-description"><p>' + data[i]['attribute_description'] + '</p></li>');
                        }
                            /* attribute_id = data[i]['attribute_id'] */
                            /* element_id = data[i]['element_id'] */
                            /* attribute_json = data[i][j]['attribute_json'] */
                            /* attribute_id = data[i][j]['attribute_id'] */
                            /* created_at = data[i][j]['created_at'] */
                            /* updated_at = data[i][j]['updated_at'] */
                        for(let j = 0; j < data[i]['count_attr']; j++){
                            if(data[i][j] != null){
                                if(data[i][j]['element_id'] != null){
                                    //console.log(data[i][j]['element_id']);
                                }
                                if(data[i][j]['attribute_img'] != null){
                                    $('#table-img-' + data[i]['attribute_id']).append('<li title="Дата создания: ' + data[i][j]['created_at'] + ' Дата изменения: ' + data[i][j]['updated_at'] + '" class="attribute-img" onclick="appendBigImg(this);">  <img id="table-img-' + data[i][j]['id'] + '" data-toggle="modal" data-target=".bd-img-modal-lg" src="' + data[i][j]['attribute_img'] + '" /></li>');
                                }
                                if(data[i][j]['attribute_text'] != null){
                                    $('#table-text-' + data[i]['attribute_id']).append('<i title="Изменить значение атрибута" id="e-v-at-' + data[i]['attribute_id'] + '" onclick="editValInputAttr(id, ' + elementID + ', ' + data[i][j]['id'] + ')" data-toggle="modal" data-target=".bd-attr-edit-value-modal-lg" class="fa fa-pencil edit-attr-value" aria-hidden="true"></i><i title="Удалить значение атрибута " id="r-at-' + data[i][j]['id'] + '" onclick="removeInputAttr(id, ' + data[i]['element_id'] + ')" data-toggle="modal" data-target=".bd-attr-remove-modal-lg" class="fa fa-times remove-attr" aria-hidden="true"></i><li title="Дата создания: ' + data[i][j]['created_at'] + ' Дата изменения: ' + data[i][j]['updated_at'] + '" class="attribute-text"> <p id="table-text-' + data[i][j]['id'] + '">' + data[i][j]['attribute_text'] + '</p></li>');
                                }
                                if(data[i][j]['attribute_varchar'] != null){
                                    $('#table-varchar-' + data[i]['attribute_id']).append('<i title="Изменить значение атрибута" id="e-v-at-' + data[i]['attribute_id'] + '" onclick="editValInputAttr(id, ' + elementID + ', ' + data[i][j]['id'] + ')" data-toggle="modal" data-target=".bd-attr-edit-value-modal-lg" class="fa fa-pencil edit-attr-value" aria-hidden="true"></i><i title="Удалить значение атрибута " id="r-at-' + data[i][j]['id'] + '" onclick="removeInputAttr(id, ' + data[i]['element_id'] + ')" data-toggle="modal" data-target=".bd-attr-remove-modal-lg" class="fa fa-times remove-attr" aria-hidden="true"></i><li title="Дата создания: ' + data[i][j]['created_at'] + ' Дата изменения: ' + data[i][j]['updated_at'] + '" class="attribute-href"> <a id="table-varchar-' + data[i][j]['id'] + '"  href="' + data[i][j]['attribute_varchar'] + '">' + data[i]['attribute_name'] + '</a> <i class="fa fa-chevron-circle-right ch-href" aria-hidden="true"></i> </li>');
                                }
                                if(data[i][j]['attribute_time_first'] != null){
                                    $('#table-time-first-' + data[i]['attribute_id']).append('<i title="Изменить значение атрибута" id="e-v-at-' + data[i]['attribute_id'] + '" onclick="editValInputAttr(id, ' + elementID + ', ' + data[i][j]['id'] + ')" data-toggle="modal" data-target=".bd-attr-edit-value-modal-lg" class="fa fa-pencil edit-attr-value" aria-hidden="true"></i><i title="Удалить значение атрибута " id="r-at-' + data[i][j]['id'] + '" onclick="removeInputAttr(id, ' + data[i]['element_id'] + ')" data-toggle="modal" data-target=".bd-attr-remove-modal-lg" class="fa fa-times remove-attr" aria-hidden="true"></i><li title="Дата создания: ' + data[i][j]['created_at'] + ' Дата изменения: ' + data[i][j]['updated_at'] + '" class="attribute-time-first"> <p id="table-time-first-' + data[i][j]['id'] + '">Время начала: ' + data[i][j]['attribute_time_first'] + '</p></li>');
                                }
                                if(data[i][j]['attribute_time_second'] != null){
                                    $('#table-time-second-' + data[i]['attribute_id']).append('<i title="Изменить значение атрибута" id="e-v-at-' + data[i]['attribute_id'] + '" onclick="editValInputAttr(id, ' + elementID + ', ' + data[i][j]['id'] + ')" data-toggle="modal" data-target=".bd-attr-edit-value-modal-lg" class="fa fa-pencil edit-attr-value" aria-hidden="true"></i><i title="Удалить значение атрибута " id="r-at-' + data[i][j]['id'] + '" onclick="removeInputAttr(id, ' + data[i]['element_id'] + ')" data-toggle="modal" data-target=".bd-attr-remove-modal-lg" class="fa fa-times remove-attr" aria-hidden="true"></i><li title="Дата создания: ' + data[i][j]['created_at'] + ' Дата изменения: ' + data[i][j]['updated_at'] + '" class="attribute-time-second"> <p id="table-time-second-' + data[i][j]['id'] + '">Время окончания: ' + data[i][j]['attribute_time_second'] + '</p></li>');
                                }
                                if(data[i][j]['attribute_int'] != null){
                                    $('#table-int-' + data[i]['attribute_id']).append('<li title="Дата создания: ' + data[i][j]['created_at'] + ' Дата изменения: ' + data[i][j]['updated_at'] + '" class="attribute-int"> <p id="table-int-' + data[i][j]['id'] + '">' + data[i][j]['attribute_int'] + '</p></li>');
                                }
                                if(data[i][j]['attribute_float'] != null){
                                    $('#table-float-' + data[i]['attribute_id']).append('<li title="Дата создания: ' + data[i][j]['created_at'] + ' Дата изменения: ' + data[i][j]['updated_at'] + '" class="attribute-float"> <p id="table-float-' + data[i][j]['id'] + '">' + data[i][j]['attribute_float'] + '</p></li>');
                                }
                                if(data[i][j]['attribute_double'] != null){
                                    $('#table-double-' + data[i]['attribute_id']).append('<li title="Дата создания: ' + data[i][j]['created_at'] + ' Дата изменения: ' + data[i][j]['updated_at'] + '" class="attribute-double"><p id="table-double-' + data[i][j]['id'] + '">' + data[i][j]['attribute_double'] + '</p></li>');
                                }
                                if(data[i][j]['attribute_bool'] != null){
                                    if(data[i][j]['attribute_bool'] == 1){
                                        $('#table-bool-' + data[i]['attribute_id']).append('<li title="Дата создания: ' + data[i][j]['created_at'] + ' Дата изменения: ' + data[i][j]['updated_at'] + '" class="attribute-bool-true"> <i class="fa fa-check-circle" aria-hidden="true"></i>  <i title="Изменить значение атрибута" id="e-v-at-' + data[i]['attribute_id'] + '" onclick="editValInputAttr(id, ' + elementID + ', ' + data[i][j]['id'] + ')" data-toggle="modal" data-target=".bd-attr-edit-value-modal-lg" class="fa fa-pencil edit-attr-value" aria-hidden="true"></i><i title="Удалить значение атрибута " id="r-at-' + data[i][j]['id'] + '" onclick="removeInputAttr(id, ' + data[i]['element_id'] + ')" data-toggle="modal" data-target=".bd-attr-remove-modal-lg" class="fa fa-times remove-attr" aria-hidden="true"></i></li>');
                                    } else if(data[i][j]['attribute_bool'] == 0){
                                        $('#table-bool-' + data[i]['attribute_id']).append('<i title="Изменить значение атрибута" id="e-v-at-' + data[i]['attribute_id'] + '" onclick="editValInputAttr(id, ' + elementID + ', ' + data[i][j]['id'] + ')" data-toggle="modal" data-target=".bd-attr-edit-value-modal-lg" class="fa fa-pencil edit-attr-value" aria-hidden="true"></i><i title="Удалить значение атрибута " id="r-at-' + data[i][j]['id'] + '" onclick="removeInputAttr(id, ' + data[i]['element_id'] + ')" data-toggle="modal" data-target=".bd-attr-remove-modal-lg" class="fa fa-times remove-attr" aria-hidden="true"></i><li title="Дата создания: ' + data[i][j]['created_at'] + ' Дата изменения: ' + data[i][j]['updated_at'] + '" class="attribute-bool-false"> <i class="fa fa-times-circle" aria-hidden="true"></i></li>');
                                    }
                                }
                                if(data[i][j]['attribute_IP'] != null){
                                    $('#table-ip-' + data[i]['attribute_id']).append('<i title="Изменить значение атрибута" id="e-v-at-' + data[i]['attribute_id'] + '" onclick="editValInputAttr(id, ' + elementID + ', ' + data[i][j]['id'] + ')" data-toggle="modal" data-target=".bd-attr-edit-value-modal-lg" class="fa fa-pencil edit-attr-value" aria-hidden="true"></i><i title="Удалить значение атрибута " id="r-at-' + data[i][j]['id'] + '" onclick="removeInputAttr(id, ' + data[i]['element_id'] + ')" data-toggle="modal" data-target=".bd-attr-remove-modal-lg" class="fa fa-times remove-attr" aria-hidden="true"></i><li title="Дата создания: ' + data[i][j]['created_at'] + ' Дата изменения: ' + data[i][j]['updated_at'] + '" class="attribute-ip"> <p id="table-ip-' + data[i][j]['id'] + '">IP: ' + data[i][j]['attribute_IP'] + '</p></li>');
                                }
                                if(data[i][j]['id'] != null){

                                    if(data[i][j]['attribute_double'] != null){
                                        $('#table-double-' + data[i][j]['id']).append('<i title="Изменить значение атрибута" id="e-v-at-' + data[i]['attribute_id'] + '" onclick="editValInputAttr(id, ' + elementID + ', ' + data[i][j]['id'] + ')" data-toggle="modal" data-target=".bd-attr-edit-value-modal-lg" class="fa fa-pencil edit-attr-value-table" aria-hidden="true"></i><i title="Удалить значение атрибута " id="r-at-' + data[i][j]['id'] + '" onclick="removeInputAttr(id, ' + data[i]['element_id'] + ')" data-toggle="modal" data-target=".bd-attr-remove-modal-lg" class="fa fa-times remove-attr-table" aria-hidden="true"></i>');
                                    }
                                    if(data[i][j]['attribute_float'] != null){
                                        $('#table-float-' + data[i][j]['id']).append('<i title="Изменить значение атрибута" id="e-v-at-' + data[i]['attribute_id'] + '" onclick="editValInputAttr(id, ' + elementID + ', ' + data[i][j]['id'] + ')" data-toggle="modal" data-target=".bd-attr-edit-value-modal-lg" class="fa fa-pencil edit-attr-value-table" aria-hidden="true"></i><i title="Удалить значение атрибута " id="r-at-' + data[i][j]['id'] + '" onclick="removeInputAttr(id, ' + data[i]['element_id'] + ')" data-toggle="modal" data-target=".bd-attr-remove-modal-lg" class="fa fa-times remove-attr-table" aria-hidden="true"></i>');
                                    }
                                    if(data[i][j]['attribute_int'] != null){
                                        $('#table-int-' + data[i][j]['id']).append('<i title="Изменить значение атрибута" id="e-v-at-' + data[i]['attribute_id'] + '" onclick="editValInputAttr(id, ' + elementID + ', ' + data[i][j]['id'] + ')" data-toggle="modal" data-target=".bd-attr-edit-value-modal-lg" class="fa fa-pencil edit-attr-value-table" aria-hidden="true"></i><i title="Удалить значение атрибута " id="r-at-' + data[i][j]['id'] + '" onclick="removeInputAttr(id, ' + data[i]['element_id'] + ')" data-toggle="modal" data-target=".bd-attr-remove-modal-lg" class="fa fa-times remove-attr-table" aria-hidden="true"></i>');
                                    }
                                    if(data[i][j]['attribute_img'] != null){
                                        $('#table-img-' + data[i][j]['id']).after('<div class="btns-edit-img"><i title="Изменить значение атрибута" id="e-v-at-' + data[i]['attribute_id'] + '" onclick="editValInputAttr(id, ' + elementID + ', ' + data[i][j]['id'] + ')" data-toggle="modal" data-target=".bd-attr-edit-value-modal-lg" class="fa fa-pencil edit-attr-value-table" aria-hidden="true"></i><i title="Удалить значение атрибута " id="r-at-' + data[i][j]['id'] + '" onclick="removeInputAttr(id, ' + data[i]['element_id'] + ')" data-toggle="modal" data-target=".bd-attr-remove-modal-lg" class="fa fa-times remove-attr-table" aria-hidden="true"></i></div>');
                                    }
                                    //console.log(data[i][j]['id']);

                                }
                            } else if(data[i][j] == null){
                                break;
                            }
                        }
                        $('#attr-el-' + elementID).append('</div>');
                    }
                }
                //elementData(event, elementID);
            }
        })
    }

    function editElement(event, elementID){
        event.preventDefault();
        elementID = Number(elementID);
        let elementName = $('.element-edit-name').val();
        $.ajax({
            url: "{{ route('admin.edit_element') }}",
            type: 'POST',
            data: {
                element_id: elementID,
                element_name: elementName
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                let idParent = $('#el-id-' + elementID).parent().attr('id');
                if(idParent == undefined){
                    location.reload();
                } else {
                    elementID = idParent.replace('element-id-', '');
                    elementDataSearch(event, elementID);
                }
            }
        })
    }

    function showAllElements(event, elementID){
        event.preventDefault();
        elementID = Number(elementID);
        let childUl = $('#element-id-' + elementID).children().length;
        if(childUl == 0){
            elementDataSearch(event, elementID);
        }
        $.ajax({
            url: "{{ route('admin.get_remove_elements') }}",
            type: 'GET',
            data: {
                element_id: elementID
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                let elementsArray = new Array();
                if(data.length != 0){
                    for(let i = 0; i < data.length; i++){
                        elementsArray.push(data[i].id);
                    }
                    if(elementsArray.length != 0){
                        for(let j = 0; j < elementsArray.length; j++){
                            showAllElements(event, elementsArray[j]);
                        }
                    }
                }
                if(elementsArray.length != 0){
                    for(let k = 0; k < elementsArray.length; k++){
                        showElements(event, elementsArray[k]);
                    }
                }
            }
        })
    }

    function showElements(event, elementID){
        event.preventDefault();
        elementID = Number(elementID);
        $.ajax({
            url: "{{ route('admin.show_elements') }}",
            type: 'POST',
            data: {
                element_id: elementID
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                elementData(event, elementID);
            }
        })
    }

    function getRemoveElements(event, elementID){
        event.preventDefault();
        elementID = Number(elementID);
        $.ajax({
            url: "{{ route('admin.get_remove_elements') }}",
            type: 'GET',
            data: {
                element_id: elementID
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                let elementsArray = new Array();
                if(data.length != 0){
                    for(let i = 0; i < data.length; i++){
                        elementsArray.push(data[i].id);
                    }
                    if(elementsArray.length != 0){
                        for(let j = 0; j < elementsArray.length; j++){
                            getRemoveElements(event, elementsArray[j]);
                        }
                    }
                }
                if(elementsArray.length != 0){
                    for(let k = 0; k < elementsArray.length; k++){
                        removeElement(event, elementsArray[k]);
                    }
                }
                removeElement(event, elementID);
                let idParent = $('#el-id-' + elementID).parent().attr('id');
                if(idParent == undefined){
                    location.reload();
                } else {
                    elementID = idParent.replace('element-id-', '');
                    elementDataSearch(event, elementID);
                }
            }
        })

    }

    function removeElement(event, elementID){
        event.preventDefault();
        elementID = Number(elementID);
        $.ajax({
            url: "{{ route('admin.remove_element') }}",
            type: 'POST',
            data: {
                element_id: elementID
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                elementData(event, elementID);
            }
        })
    }

    function createNote(event, complexID){
        event.preventDefault();
        let elementNameValue;
        let parentID = null;
        if(complexID == null){
            elementNameValue = $('.element-name').val();
            parentID = null;
        } else if(complexID != null){
            elementNameValue = $('.element-name-complex').val();
            let array_id = complexID.split('-');
            parentID = array_id[array_id.length - 1];
        }
        $.ajax({
            url: "{{ route('admin.create_note') }}",
            type: 'POST',
            data: {
                element_name: elementNameValue,
                parent_id: parentID,
                parent_complex_id: complexID
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                if(parentID == null){
                    location.reload();
                } else {
                    elementDataSearch(event, parentID);
                }
            }
        })
    }

    // function moveElTo(event, element, elementID){
    //     event.preventDefault();
    //     let select = $('#' + element.id).parent('.input-group-append').prev();
    //     let options = select[0];
    //     for(let i = 0; i < options.length; i++){
    //         if(options[i].selected == true){
    //             let elID = options[i].id;
    //             let complex = elID.replace('complex-id-', '');
    //             let cx = complex.replace('-' + elementID, '')
    //             let complexArray = complex.split('-');
    //             let parentElID = complexArray[complexArray.length - 2];
    //             let newComplex = cx + '-' + elementID;
    //             $.ajax({
    //                 url: "{{ route('admin.move_element') }}",
    //                 type: 'POST',
    //                 data: {
    //                     parent_id: parentElID,
    //                     complex_id: newComplex,
    //                     element_id: elementID
    //                 },
    //                 headers: {
    //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //                 },
    //                 success: (data) => {

    //                 }
    //             })
    //         }
    //     }
    // }

    // function getElements(elementID){
    //     $('.btn-select').css('display', 'none');
    //     $('.element-select').css('display', 'none');
    //     $('#select-id-' + elementID).css('display', 'inline-block');
    //     $('#btn-select-id-' + elementID).css('display', 'block');
    //     $.ajax({
    //         url: "{{ route('admin.get_elements') }}",
    //         type: 'GET',
    //         data: {},
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         success: (data) => {
    //             for(let i = 0; i < data.length; i++){
    //                 $('#select-id-' + elementID).append('<option id="complex-id-' + data[i].complex_id + '">' + data[i].element_name + '</option>');
    //             }
    //             //console.log(data);
    //         }
    //     })
    // }

    // function moveElement(event, elementID){
    //     event.preventDefault();
    //     getElements(elementID);
    //     //console.log(elementID);

    // }

    function elementData(event, parentID){
        event.preventDefault();
        let elFind = $('#el-id-' + parentID).children('.elements').children('li');
        let elstyle = $('#el-id-' + parentID).children('.elements').children('li').css('display');
        let attrFind = $('#el-id-' + parentID).children('.attributes').children('.attr-container');
        let attrstyle = $('#el-id-' + parentID).children('.attributes').children('.attr-container').css('display');
        if(elFind.length == 0){
            attributeData(event, parentID);
            parentID = Number(parentID);
            $.ajax({
                url: "{{ route('admin.element_data') }}",
                type: 'GET',
                data: {
                    parent_id: parentID
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {
                    if(data.length != 0){
                        $('#element-id-' + parentID).empty();
                        for(let i = 0; i < data.length; i++){
                            let children = $('#element-id-' + parentID).children();
                            let del = "'";
                            let a1 ='<a onclick="elementData(event, ' + data[i].id + ')">' + data[i].element_name + '</a>';
                            let i1 = '<i title="Удалить элемент ' + data[i].element_name + '" onclick="getRemoveElements(event, ' + data[i].id + ')"  class="fa fa-times remove-element" aria-hidden="true"  ></i>';
                            let i2 = '<i title="Редактировать раздел ' + data[i].element_name + '" onclick="inputEditID(' + data[i].id + ')" class="fa fa-pencil-square-o edit-element" aria-hidden="true" data-toggle="modal" data-target=".bd-edit-modal-lg"></i>';
                            let i3 = '<i title="Создать элемент для ' + data[i].element_name + '"  onclick="inputID(' + del + data[i].complex_id + del + ')" class="fa fa-sun-o new-element" aria-hidden="true" data-toggle="modal" data-target=".bd-child-modal-lg"></i>';
                            let i4 = '<i data-toggle="modal" data-target=".bd-attr-modal-lg" class="fa fa-puzzle-piece new-attribute" aria-hidden="true" onclick="inputAttrID(' + data[i].id + ')" title="Создать атрибут"></i>';
                            let i5 = '<i onclick="moveElement(event, ' + data[i].id + ')" title="Переместить элемент" class="fa fa-external-link move-element" aria-hidden="true"></i>';
                            let select6 = '<div class="input-group"><select class="element-select custom-select" id="select-id-' + data[i].id + '" style="display: none;"></select>  <div class="input-group-append"><button id="btn-select-id-' + data[i].id + '" onclick="moveElTo(event, this, ' + data[i].id + ')" class="btn btn-select btn-outline-secondary" type="button" style="display: none;">Переместить</button></div></div>';
                            let attrUL7 = '<ul class="attributes" id="attr-el-' + data[i].id + '"></ul>';
                            let elementsUL8 = '<ul class="elements" id="element-id-' + data[i].id + '"></ul>';
                            let allEl = a1 + i1 + i2 + i3 + i4 + attrUL7 + elementsUL8;
                            $('#element-id-' + parentID).append('<li id="el-id-' + data[i].id + '">' + allEl + '</li>');
                            //attributeData(event, data[i].id);
                        }
                    } else {
                        $('#element-id-' + parentID).empty();
                        $('#element-id-' + parentID).append('<li><a class="empty-element">Не имеется элементов</a></li>')
                    }
                }
            })
        } else if(elFind.length != 0 && elstyle == 'list-item'){
            $('#el-id-' + parentID).children('.elements').children('li').hide();
            if(attrFind.length != 0 && attrstyle == 'block'){
                $('#el-id-' + parentID).children('.attributes').children('.attr-container').hide();
            }
        } else if(elFind.length != 0 && elstyle == 'none'){
            $('#el-id-' + parentID).children('.elements').children('li').show();
            if(attrFind.length != 0 && attrstyle == 'none'){
                $('#el-id-' + parentID).children('.attributes').children('.attr-container').show();
            }
        }
    }

    function elementDataSearch(event, parentID){
        event.preventDefault();
        attributeData(event, parentID);
        parentID = Number(parentID);
        $.ajax({
            url: "{{ route('admin.element_data') }}",
            type: 'GET',
            data: {
                parent_id: parentID
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                if(data.length != 0){
                    $('#element-id-' + parentID).empty();
                    for(let i = 0; i < data.length; i++){
                        let children = $('#element-id-' + parentID).children();
                        let del = "'";
                        let a1 = '<a onclick="elementData(event, ' + data[i].id + ')">' + data[i].element_name + '</a>';
                        let i2 = '<i title="Удалить элемент ' + data[i].element_name + '" onclick="getRemoveElements(event, ' + data[i].id + ')"  class="fa fa-times remove-element" aria-hidden="true"  ></i>';
                        let i3 = '<i title="Редактировать раздел ' + data[i].element_name + '" onclick="inputEditID(' + data[i].id + ')" class="fa fa-pencil-square-o edit-element" aria-hidden="true" data-toggle="modal" data-target=".bd-edit-modal-lg"></i>';
                        let i4 = '<i title="Создать элемент для ' + data[i].element_name + '"  onclick="inputID(' + del + data[i].complex_id + del + ')" class="fa fa-sun-o new-element" aria-hidden="true" data-toggle="modal" data-target=".bd-child-modal-lg"></i>';
                        let i5 = '<i data-toggle="modal" data-target=".bd-attr-modal-lg" class="fa fa-puzzle-piece new-attribute" aria-hidden="true" onclick="inputAttrID(' + data[i].id + ')" title="Создать атрибут"></i>';
                        let ul6 = '<ul class="attributes" id="attr-el-' + data[i].id + '"></ul>';
                        let ul7 = '<ul class="elements" id="element-id-' + data[i].id + '"></ul>';
                        let allEl = a1 + i2 + i3 + i4 + i5 + ul6 + ul7;
                        $('#element-id-' + parentID).append('<li id="el-id-' + data[i].id + '">' + allEl + '</li>');
                        //attributeData(event, data[i].id);
                    }
                } else {
                    $('#element-id-' + parentID).empty();
                    $('#element-id-' + parentID).append('<li><a class="empty-element">Не имеется элементов</a></li>');
                }
            }
        })
    }

    function emptyForms(){
        $('.clear-input').val('');
        $('.radio-checked').attr('checked', 'checked');
        $('.radio-checked').trigger('click');
        $('.link').attr('href', '');
        $('.link-edit').attr('href', '');
    }

    function inputID(complexID){
        emptyForms();
        $('.create-child').attr('id', complexID);
    }

    function inputEditID(elementID){
        emptyForms();
        $('.edit-element').attr('id', elementID);
    }

    function inputAttrID(elementID){
        emptyForms();
        $('.attr-element').attr('id', elementID);
        $('.attr-id').attr('value', elementID)
    }

    function encodeImageEdit(element) {
        var file = element.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
            $('.link-edit').attr('href', reader.result);
        }
        reader.readAsDataURL(file);
    }

    function encodeImage(element) {
        var file = element.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
            $('.link').attr('href', reader.result);
        }
        reader.readAsDataURL(file);
    }

</script>

@endsection
