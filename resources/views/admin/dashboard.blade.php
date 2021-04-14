@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <nav class="dash-vertical-menu">
                        <ul class="elements">
                            @foreach($elements as $element)
                                <li id="el-id-{{ $element->id }}">
                                    <a class="section-href" href="" onclick="elementData(event, '{{ $element->id }}')">
                                        {{ $element->element_name }}
                                    </a>
                                    <i title="Показать все" onclick="showAllElements(event, '{{ $element->id }}')" class="fa fa-bars show-all" aria-hidden="true"></i>
                                    <i title="Удалить раздел {{ $element->element_name }}"                        onclick="getRemoveElements(event, '{{ $element->id }}')"  class="fa fa-times remove-element"         aria-hidden="true"  ></i>
                                    <i title="Редактировать раздел {{ $element->element_name }}"                  onclick="inputEditID('{{ $element->id }}')" class="fa fa-pencil-square-o edit-element" aria-hidden="true" data-toggle="modal" data-target=".bd-edit-modal-lg"></i>
                                    <i title="Создать дочерний элемент для раздела {{ $element->element_name }}"  onclick="inputID('{{ $element->complex_id }}')"     class="fa fa-sun-o new-element"            aria-hidden="true" data-toggle="modal" data-target=".bd-child-modal-lg"></i>
                                    <ul class="elements" id="element-id-{{ $element->id }}"></ul>
                                </li>
                            @endforeach

                            <li><a data-toggle="modal" data-target=".bd-example-modal-lg" >+ Добавить раздел</a></li>
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
                                            <input type="text" class="element-name form-control" name="element-name" placeholder="Название раздела">
                                            <input type="submit" class="btn btn-success" data-dismiss="modal" aria-label="Close" onclick="createNote(event, null)" value="Создать раздел">

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
                                            <input type="text" class="element-name-complex form-control" name="element-name" placeholder="Название элемента">
                                            <input type="submit" class="btn btn-success create-child" data-dismiss="modal" aria-label="Close" onclick="createNote(event, id)" value="Создать элемент">
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
                                            <input type="text" class="element-edit-name form-control" name="element-name" placeholder="Новое название элемента">
                                            <input type="submit" class="btn btn-success edit-element" data-dismiss="modal" aria-label="Close" onclick="editElement(event, id)" value="Изменить">
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
                                            <input class="element-attr-name form-control" placeholder="Новое название Атрибута" type="text" name="attribute-name"/>
                                            <input class="element-attr-name form-control" placeholder="Новое описание" type="text" name="description"/>
                                            <input type="submit" class="btn btn-success edit-attr-btn" data-dismiss="modal" aria-label="Close" onclick="editAttr(event, id)" value="Изменить атрибут">
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
                                            <input class="element-attr-name form-control" placeholder="Название Атрибута" type="text" name="attribute-name"/>
                                            <span class="span-attribute">Описание Атрибута</span>
                                            <input class="element-attr-name form-control" placeholder="Описание" type="text" name="description"/>
                                            <span class="span-attribute">Значение Атрибута (Целое число)</span>
                                            <input class="element-attr-name form-control" placeholder="Номинальное значение" type="number" name="number-attribute"/> 
                                            <span class="span-attribute">Значение Атрибута (Дробное число - точность 2 после запятой)</span>
                                            <input class="element-attr-name form-control" placeholder="Номинальное значение" type="number" name="double-2"/> 
                                            <span class="span-attribute">Значение Атрибута (Дробное число - точность 15 после запятой)</span>
                                            <input class="element-attr-name form-control" placeholder="Номинальное значение" type="number" name="double-15"/> 
                                            <span class="span-attribute">Время начала</span> 
                                            <input class="element-attr-name form-control" placeholder="Время" type="time" name="time-first"/> 
                                            <span class="span-attribute">Время окончания</span> 
                                            <input class="element-attr-name form-control" placeholder="Время" type="time" name="time-second"/> 
                                            <span class="span-attribute">Текст Атрибута</span>
                                            <textarea class="element-attr-name form-control" placeholder="Текст" type="text" name="attribute-text"></textarea>
                                            <span class="span-attribute">Ссылка на источник</span>
                                            <input class="element-attr-name form-control" placeholder="https://www.source.com" type="text" name="attribute-varchar"/> 
                                            <input class="element-attr-name form-control file-input" onchange="encodeImage(this)" type="file" name="attribute-file"/> 
                                            <a class="link"></a> 
                                            <span class="span-attribute">Да</span> 
                                            <input class="element-attr-name form-control input-radio-attribute" type="radio" name="attribute-bool" value="1" /> 
                                            <span class="span-attribute">Нет</span> 
                                            <input class="element-attr-name form-control input-radio-attribute" type="radio" name="attribute-bool" value="0"/> 
                                            <span class="span-attribute">Пусто</span> 
                                            <input class="element-attr-name form-control input-radio-attribute" type="radio" name="attribute-bool" value="" checked/> 
                                            <input class="element-attr-name form-control" placeholder="IP адрес" type="text" name="attribute-ip"/>
                                            <input class="element-attr-name form-control attr-id" type="text" name="attrubute-id"/> 
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

    function removeInputAttr(attrID){
        console.log(attrID);
    }

    function editInputAttr(attrID, elementID){
        attrID = attrID.replace('e-at-', '');
        $('.edit-attr-btn').attr('id', 'edit-attr-' + attrID);
        $('.input-edit-attr').attr('id', 'el-ed-art-' + elementID);
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
                        elementData(event, data[i]);
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
                            $('#attr-el-' + elementID).append('<div class="attr-container" id="attr-div-' + data[i]['attribute_id'] + '"> <i id="r-at-' + data[i]['attribute_id'] + '" onclick="removeInputAttr(id)" data-toggle="modal" data-target=".bd-attr-remove-modal-lg" class="fa fa-times remove-attr" aria-hidden="true"></i> <i id="e-at-' + data[i]['attribute_id'] + '" onclick="editInputAttr(id, ' + elementID + ')" data-toggle="modal" data-target=".bd-attr-edit-modal-lg" class="fa fa-pencil-square-o edit-attr" aria-hidden="true"></i> <li class="attribute-title"><p>' + data[i]['attribute_name'] + '</p></li>');
                        }
                        if(data[i]['attribute_description'] != null){
                            $('#attr-div-' + data[i]['attribute_id']).append('<li class="attribute-description"><p>' + data[i]['attribute_description'] + '</p></li>');
                        }
                            /* attribute_id = data[i]['attribute_id'] */
                            /* element_id = data[i]['element_id']*/
                            /* attribute_json = data[i][j]['attribute_json'] */   
                            /* attribute_id = data[i][j]['attribute_id'] */
                            /* created_at = data[i][j]['created_at'] */
                            /* updated_at = data[i][j]['updated_at'] */

                        for(let j = 0; j < data[i]['count_attr']; j++){
                            if(data[i][j] != null){
                                if(data[i][j]['id'] != null){
                                    //console.log(data[i][j]['id']);
                                }
                                if(data[i][j]['element_id'] != null){
                                    //console.log(data[i][j]['element_id']);
                                }

                                if(data[i][j]['attribute_img'] != null){
                                    $('#attr-div-' + data[i]['attribute_id']).append('<li class="attribute-img" onclick="appendBigImg(this);"> <i id="r-at-' + data[i]['attribute_id'] + '" onclick="removeInputAttr(id)" data-toggle="modal" data-target=".bd-attr-remove-modal-lg" class="fa fa-times remove-attr" aria-hidden="true"></i> <i id="e-at-' + data[i]['attribute_id'] + '" onclick="editInputAttr(id, ' + elementID + ')" data-toggle="modal" data-target=".bd-attr-edit-modal-lg" class="fa fa-pencil-square-o edit-attr" aria-hidden="true"></i> <img data-toggle="modal" data-target=".bd-img-modal-lg" src="' + data[i][j]['attribute_img'] + '" /></li>');
                                }

                                if(data[i][j]['attribute_text'] != null){
                                    $('#attr-div-' + data[i]['attribute_id']).append('<li class="attribute-text"> <i id="r-at-' + data[i]['attribute_id'] + '" onclick="removeInputAttr(id)" data-toggle="modal" data-target=".bd-attr-remove-modal-lg" class="fa fa-times remove-attr" aria-hidden="true"></i> <i id="e-at-' + data[i]['attribute_id'] + '" onclick="editInputAttr(id, ' + elementID + ')" data-toggle="modal" data-target=".bd-attr-edit-modal-lg" class="fa fa-pencil-square-o edit-attr" aria-hidden="true"></i> <p>' + data[i][j]['attribute_text'] + '</p></li>');
                                }

                                if(data[i][j]['attribute_varchar'] != null){
                                    $('#attr-div-' + data[i]['attribute_id']).append('<li class="attribute-href"> <i id="r-at-' + data[i]['attribute_id'] + '" onclick="removeInputAttr(id)" data-toggle="modal" data-target=".bd-attr-remove-modal-lg" class="fa fa-times remove-attr" aria-hidden="true"></i> <i id="e-at-' + data[i]['attribute_id'] + '" onclick="editInputAttr(id, ' + elementID + ')" data-toggle="modal" data-target=".bd-attr-edit-modal-lg" class="fa fa-pencil-square-o edit-attr" aria-hidden="true"></i> <a href="' + data[i][j]['attribute_varchar'] + '">' + data[i]['attribute_name'] + '</a> <i class="fa fa-chevron-circle-right ch-href" aria-hidden="true"></i> </li>');
                                }
                                if(data[i][j]['attribute_time_first'] != null){
                                    $('#attr-div-' + data[i]['attribute_id']).append('<li class="attribute-time-first"> <i id="r-at-' + data[i]['attribute_id'] + '" onclick="removeInputAttr(id)" data-toggle="modal" data-target=".bd-attr-remove-modal-lg" class="fa fa-times remove-attr" aria-hidden="true"></i> <i id="e-at-' + data[i]['attribute_id'] + '" onclick="editInputAttr(id, ' + elementID + ')" data-toggle="modal" data-target=".bd-attr-edit-modal-lg" class="fa fa-pencil-square-o edit-attr" aria-hidden="true"></i> <p>' + data[i][j]['attribute_time_first'] + '</p></li>');
                                }
                                if(data[i][j]['attribute_time_second'] != null){
                                    $('#attr-div-' + data[i]['attribute_id']).append('<li class="attribute-time-second"> <i id="r-at-' + data[i]['attribute_id'] + '" onclick="removeInputAttr(id)" data-toggle="modal" data-target=".bd-attr-remove-modal-lg" class="fa fa-times remove-attr" aria-hidden="true"></i> <i id="e-at-' + data[i]['attribute_id'] + '" onclick="editInputAttr(id, ' + elementID + ')" data-toggle="modal" data-target=".bd-attr-edit-modal-lg" class="fa fa-pencil-square-o edit-attr" aria-hidden="true"></i> <p>' + data[i][j]['attribute_time_second'] + '</p></li>');
                                }
                                if(data[i][j]['attribute_int'] != null){
                                    $('#attr-div-' + data[i]['attribute_id']).append('<li class="attribute-int"> <i id="r-at-' + data[i]['attribute_id'] + '" onclick="removeInputAttr(id)" data-toggle="modal" data-target=".bd-attr-remove-modal-lg" class="fa fa-times remove-attr" aria-hidden="true"></i> <i id="e-at-' + data[i]['attribute_id'] + '" onclick="editInputAttr(id, ' + elementID + ')" data-toggle="modal" data-target=".bd-attr-edit-modal-lg" class="fa fa-pencil-square-o edit-attr" aria-hidden="true"></i> <p>' + data[i][j]['attribute_int'] + '</p></li>');
                                }
                                if(data[i][j]['attribute_float'] != null){
                                    $('#attr-div-' + data[i]['attribute_id']).append('<li class="attribute-float"> <i id="r-at-' + data[i]['attribute_id'] + '" onclick="removeInputAttr(id)" data-toggle="modal" data-target=".bd-attr-remove-modal-lg" class="fa fa-times remove-attr" aria-hidden="true"></i> <i id="e-at-' + data[i]['attribute_id'] + '" onclick="editInputAttr(id, ' + elementID + ')" data-toggle="modal" data-target=".bd-attr-edit-modal-lg" class="fa fa-pencil-square-o edit-attr" aria-hidden="true"></i> <p>' + data[i][j]['attribute_float'] + '</p></li>');
                                }
                                if(data[i][j]['attribute_double'] != null){
                                    $('#attr-div-' + data[i]['attribute_id']).append('<li class="attribute-double"> <i id="r-at-' + data[i]['attribute_id'] + '" onclick="removeInputAttr(id)" data-toggle="modal" data-target=".bd-attr-remove-modal-lg" class="fa fa-times remove-attr" aria-hidden="true"></i> <i id="e-at-' + data[i]['attribute_id'] + '" onclick="editInputAttr(id, ' + elementID + ')" data-toggle="modal" data-target=".bd-attr-edit-modal-lg" class="fa fa-pencil-square-o edit-attr" aria-hidden="true"></i><p>' + data[i][j]['attribute_double'] + '</p></li>');
                                }
                                if(data[i][j]['attribute_bool'] != null){
                                    if(data[i][j]['attribute_bool'] == 1){
                                        $('#attr-div-' + data[i]['attribute_id']).append('<li class="attribute-bool-true"> <i id="r-at-' + data[i]['attribute_id'] + '" onclick="removeInputAttr(id)" data-toggle="modal" data-target=".bd-attr-remove-modal-lg" class="fa fa-times remove-attr" aria-hidden="true"></i> <i id="e-at-' + data[i]['attribute_id'] + '" onclick="editInputAttr(id, ' + elementID + ')" data-toggle="modal" data-target=".bd-attr-edit-modal-lg" class="fa fa-pencil-square-o edit-attr" aria-hidden="true"></i> <i class="fa fa-check-circle" aria-hidden="true"></i></li>');
                                    } else if(data[i][j]['attribute_bool'] == 0){
                                        $('#attr-div-' + data[i]['attribute_id']).append('<li class="attribute-bool-false"> <i id="r-at-' + data[i]['attribute_id'] + '" onclick="removeInputAttr(id)" data-toggle="modal" data-target=".bd-attr-remove-modal-lg" class="fa fa-times remove-attr" aria-hidden="true"></i> <i id="e-at-' + data[i]['attribute_id'] + '" onclick="editInputAttr(id, ' + elementID + ')" data-toggle="modal" data-target=".bd-attr-edit-modal-lg" class="fa fa-pencil-square-o edit-attr" aria-hidden="true"></i> <i class="fa fa-times-circle" aria-hidden="true"></i></li>');
                                    }  
                                }
                                if(data[i][j]['attribute_IP'] != null){
                                    $('#attr-div-' + data[i]['attribute_id']).append('<li class="attribute-ip"> <i id="r-at-' + data[i]['attribute_id'] + '" onclick="removeInputAttr(id)" data-toggle="modal" data-target=".bd-attr-remove-modal-lg" class="fa fa-times remove-attr" aria-hidden="true"></i> <i id="e-at-' + data[i]['attribute_id'] + '" onclick="editInputAttr(id, ' + elementID + ')" data-toggle="modal" data-target=".bd-attr-edit-modal-lg" class="fa fa-pencil-square-o edit-attr" aria-hidden="true"></i> <p>' + data[i][j]['attribute_IP'] + '</p></li>');
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
                    elementData(event, elementID);
                } 
            }
        })
    }

    function showAllElements(event, elementID){
        event.preventDefault();
        elementID = Number(elementID);
        let childUl = $('#element-id-' + elementID).children().length;
        if(childUl == 0){
            elementData(event, elementID);
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
                    elementData(event, elementID);
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
                    elementData(event, parentID);
                } 
            }
        })
    }

    function elementData(event, parentID){
        parentID = Number(parentID);
        event.preventDefault();
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
                        $('#element-id-' + parentID).append('<li id="el-id-' + data[i].id + '"><a onclick="elementData(event, ' + data[i].id + ')">' + data[i].element_name + '</a> <i title="Показать все" onclick="showAllElements(event, ' + data[i].id + ')" class="fa fa-bars show-all" aria-hidden="true"></i> <i title="Удалить элемент ' + data[i].element_name + '" onclick="getRemoveElements(event, ' + data[i].id + ')"  class="fa fa-times remove-element" aria-hidden="true"  ></i> <i title="Редактировать раздел ' + data[i].element_name + '" onclick="inputEditID(' + data[i].id + ')" class="fa fa-pencil-square-o edit-element" aria-hidden="true" data-toggle="modal" data-target=".bd-edit-modal-lg"></i> <i title="Создать дочерний элемент для ' + data[i].element_name + '"  onclick="inputID(' + del + data[i].complex_id + del + ')" class="fa fa-sun-o new-element" aria-hidden="true" data-toggle="modal" data-target=".bd-child-modal-lg"></i> <i data-toggle="modal" data-target=".bd-attr-modal-lg" class="fa fa-puzzle-piece new-attribute" aria-hidden="true" onclick="inputAttrID(' + data[i].id + ')" title="Создать атрибут"></i> <ul class="attributes" id="attr-el-' + data[i].id + '"></ul> <ul class="elements" id="element-id-' + data[i].id + '"></ul></li>');
                        attributeData(event, data[i].id);
                    }
                } else {
                    $('#element-id-' + parentID).empty();
                    $('#element-id-' + parentID).append('<li><a class="empty-element">Не имеется элементов</a></li>')
                }
            }
        })
    }

    function inputID(complexID){
        $('.create-child').attr('id', complexID);
    }

    function inputEditID(elementID){
        $('.edit-element').attr('id', elementID);
    }

    function inputAttrID(elementID){
        $('.attr-element').attr('id', elementID);
        $('.attr-id').attr('value', elementID)
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