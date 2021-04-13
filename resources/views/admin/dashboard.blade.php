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
                                            <input class="element-attr-name form-control" placeholder="Текст" type="text" name="attribute-text"/>
                                            <span class="span-attribute">Ссылка на источник</span>
                                            <input class="element-attr-name form-control" placeholder="https://www.source.com" type="text" name="attribute-varchar"/> 
                                            <input class="element-attr-name form-control file-input" onchange="encodeImage(this)" type="file" name="attribute-file"/> 
                                            <a class="link"></a> 
                                            <span class="span-attribute">Да</span> 
                                            <input class="element-attr-name form-control input-radio-attribute" type="radio" name="attribute-bool" value="true" /> 
                                            <span class="span-attribute">Нет</span> 
                                            <input class="element-attr-name form-control input-radio-attribute" type="radio" name="attribute-bool" value="false"/> 
                                            <span class="span-attribute">Пусто</span> 
                                            <input class="element-attr-name form-control input-radio-attribute" type="radio" name="attribute-bool" value="null" checked/> 
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

        $.ajax({
            url: "{{ route('admin.create_attr') }}",
            type: 'POST',
            data: {
                attrubute_id: inputArray['attrubute-id'],
                attribute_bool: inputArray['attribute-bool'],
                attribute_file: inputArray['attribute-file'],
                attribute_ip: inputArray['attribute-ip'],
                attribute_name: inputArray['attribute-name'],
                attribute_text: inputArray['attribute-text'],
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
                elementData(event, elementID);
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
                        $('#element-id-' + parentID).append('<li id="el-id-' + data[i].id + '"><a onclick="elementData(event, ' + data[i].id + ')">' + data[i].element_name + '</a> <i title="Показать все" onclick="showAllElements(event, ' + data[i].id + ')" class="fa fa-bars show-all" aria-hidden="true"></i> <i title="Удалить элемент ' + data[i].element_name + '" onclick="getRemoveElements(event, ' + data[i].id + ')"  class="fa fa-times remove-element" aria-hidden="true"  ></i> <i title="Редактировать раздел ' + data[i].element_name + '" onclick="inputEditID(' + data[i].id + ')" class="fa fa-pencil-square-o edit-element" aria-hidden="true" data-toggle="modal" data-target=".bd-edit-modal-lg"></i> <i title="Создать дочерний элемент для ' + data[i].element_name + '"  onclick="inputID(' + del + data[i].complex_id + del + ')" class="fa fa-sun-o new-element" aria-hidden="true" data-toggle="modal" data-target=".bd-child-modal-lg"></i> <i data-toggle="modal" data-target=".bd-attr-modal-lg" class="fa fa-puzzle-piece new-attribute" aria-hidden="true" onclick="inputAttrID(' + data[i].id + ')" title="Создать атрибут"></i> <ul class="elements" id="element-id-' + data[i].id + '"></ul></li>');
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

    /* ---- Incode Image ----*/ 

</script>

@endsection