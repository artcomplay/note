@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="row">
                <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <nav class="dash-vertical-menu">
                        <ul class="sections">
                            @foreach($sections as $section)
                                <li id="section-id-{{ $section->id }}">
                                    <a class="section-href" href="" onclick="sectionData(event, '{{ $section->name }}', '{{ $section->id }}')">
                                        {{ $section->name }}
                                    </a>
                                    <i id="remove-section" class="fa fa-times remove-section" aria-hidden="true" onclick="removeSection(event, '{{ $section->name }}', '{{ $section->id }}')" title="Удалить раздел {{ $section->name }}"></i> <i title="Редактировать раздел" onclick="editElement('{{ $section->id }}', 1)" class="fa fa-pencil-square-o edit-element" aria-hidden="true"></i>
                                    <div class="row edit-section" id="edit-section-{{ $section->id }}"></div>
                                </li>
                            @endforeach

                            <li><a href="" onclick="appendInput(event)">+ Добавить раздел</a></li>
                        </ul>
                    </nav>
                </div>

                <div class="main-block-section col-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
                    <body>
                        <div class="warning-block"></div>
                        <ul class="categories">
                            
                        </ul>
                    </body>
                </div>


                



            </div>
        </div>
    </div>


@endsection

@section('custom_js')
<script>

    /* ---- Edit Element ----*/

    function editElementSuccess(event, elementType, elementID){
        event.preventDefault();

        let elementTypeNameGet = elementTypeName(elementType);
        let editNameInput = $('#input-edit-' + elementTypeNameGet + '-' + elementID).val();
        if(editNameInput != null && elementType != null && elementID != null){
            $.ajax({
                url: "{{ route('admin.edit_element') }}",
                type: 'POST',
                data: {
                    elementID: elementID,
                    elementType: elementType,
                    editName: editNameInput
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {
                    if(elementType == 2){
                        getSectionIdForEdit(event, elementID);
                    } else if(elementType == 3){
                        getCategoryIdForEdit(event, elementID);
                    }
                    
                }
            })
        }
    }

    function updataSections(){
        console.log('updataSections');
        $.ajax({
            url: "{{ route('admin.dashboard') }}",
            type: 'GET',
            data: {

            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                $('body').empty();
                $('body').append(data);
            }
        })
    }



    function showHideEdit(elementID, elementType){
        
        let elementTypeNameGet = elementTypeName(elementType);
        
        let el = $('#input-edit-' + elementTypeNameGet + '-' + elementID);

        if(elementType == 1){
            $('.edit-category').children().hide();
            $('.edit-subject').children().hide();
            $('.edit-element').children().hide();
        } else if(elementType == 2){
            $('.edit-section').children().hide();
            $('.edit-subject').children().hide();
            $('.edit-element').children().hide();
        } else if(elementType == 3){
            $('.edit-section').children().hide();
            $('.edit-category').children().hide();
            $('.edit-element').children().hide();
        } else if(elementType == 3){
            $('.edit-section').children().hide();
            $('.edit-category').children().hide();
            $('.edit-subject').children().hide();
        }

        if(el.length == 1 && el.css('display') == 'block'){
            el.hide();
            el.next().hide();
        } else if(el.length == 1 && el.css('display') == 'none'){
            $('.edit-section').children().hide();
            $('.edit-category').children().hide();
            $('.edit-subject').children().hide();
            $('.edit-element').children().hide();
            el.show();
            el.next().show();
        } else if(el.length == 0 && el.css('display') == undefined){
            $('.edit-section').children().hide();
            $('.edit-category').children().hide();
            $('.edit-subject').children().hide();
            $('.edit-element').children().hide();
            $('#edit-' + elementTypeNameGet + '-' + elementID).append('<input class="form-control" id="input-edit-' + elementTypeNameGet + '-' + elementID + '" type="text"/><a href="" onclick="editElementSuccess(event, ' + elementType + ', ' + elementID + ')" class="create-button" >Изменить</a>');
        } 
    }

    function editElement(elementID, elementType){
        showHideEdit(elementID, elementType);
    }

    function elementTypeName(elementType){
        let elType;
        if(elementType == 1){
            elType = 'section';
        } else if(elementType == 2){
            elType = 'category';
        } else if(elementType == 3){
            elType = 'subject';
        } else if(elementType == 4){
            elType = 'element';
        }

        return elType;
    }


    /* ---- Edit Element ----*/



    /*---- Section ----*/

    function attributesData(event, categoryID){
        let attributesData;
        $.ajax({
            url: "{{ route('admin.attributes_data') }}",
            type: 'GET',
            data: {
                categoryID: categoryID
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                if(data.length != 0){
                    attributesData = data;
                    
                    if(data.length != 0){
                        //console.log(attributesData);
                        for(let i = 0; i < attributesData.length; i++){
                            if(attributesData[i].attribute_name != null){
                                $('#attributes-row-' + categoryID).append('<li title="Дата создания атрибута ' + attributesData[i].created_at + '. Дата обновления атрибута ' + attributesData[i].updated_at + '">' + attributesData[i].attribute_name + '</li>');
                                if(attributesData[i].attribute_img != null){
                                    $('#attributes-row-' + categoryID).append('<li style="width: 100%;"></li>');
                                }
                            }
                            if(attributesData[i].attribute_description != null){
                                $('#attributes-row-' + categoryID).append('<li>' + attributesData[i].attribute_description + '</li>');
                            }
                            if(attributesData[i].attribute_double != null){
                                $('#attributes-row-' + categoryID).append('<li>' + attributesData[i].attribute_double + '</li>');
                            }
                            if(attributesData[i].attribute_float != null){
                                $('#attributes-row-' + categoryID).append('<li>' + attributesData[i].attribute_float + '</li>');
                            }
                            if(attributesData[i].attribute_int != null){
                                $('#attributes-row-' + categoryID).append('<li>' + attributesData[i].attribute_int + '</li>');
                            }
                            if(attributesData[i].attribute_text != null){
                                $('#attributes-row-' + categoryID).append('<li>' + attributesData[i].attribute_text + '</li>');
                            }
                            if(attributesData[i].attribute_time_first != null){
                                $('#attributes-row-' + categoryID).append('<li>' + attributesData[i].attribute_time_first + '</li>');
                            }
                            if(attributesData[i].attribute_time_second != null){
                                $('#attributes-row-' + categoryID).append('<li>' + attributesData[i].attribute_time_second + '</li>');
                            }
                            if(attributesData[i].attribute_varchar != null){
                                $('#attributes-row-' + categoryID).append('<li>' + attributesData[i].attribute_varchar + '</li>');
                            }
                            if(attributesData[i].attribute_img != null){
                                $('#attributes-row-' + categoryID).append('<li class="li-image-attribute"><img class="attribute-image" data-toggle="modal" data-target="#bd-example-modal-lg-' + attributesData[i].id + '" src="' + attributesData[i].attribute_img + '"/></li>');
                                $('#attributes-row-' + categoryID).append('<div id="bd-example-modal-lg-' + attributesData[i].id + '" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button><img class="modal-image" data-toggle="modal" data-target=".bd-example-modal-lg" src="' + attributesData[i].attribute_img + '"/></div></div></div>');
                            }
                            if(attributesData[i].created_at != null){
                                //$('#attributes-row-' + categoryID).append('<li>' + attributesData[i].created_at + '</li>');
                            }
                            if(attributesData[i].updated_at != null){
                                //$('#attributes-row-' + categoryID).append('<li>' + attributesData[i].updated_at + '</li>');
                            }
                            if(attributesData[i].attribute_bool != null && attributesData[i].attribute_bool == 1){
                                $('#attributes-row-' + categoryID).append('<li>Да</li>');
                            } else if(attributesData[i].attribute_bool != null && attributesData[i].attribute_bool == 0){
                                $('#attributes-row-' + categoryID).append('<li>Нет</li>');
                            }
                            $('#attributes-row-' + categoryID).append('<li style="width: 100%;"></li>');
                            
                        }
                    } else {
                        
                    }

                } else{
                    $('#attributes-row-' + categoryID).append('<li> Не содержится атрибутов </li>');
                }
            }
        })
    }

    function sectionData(event, sectionName, idSection){
        event.preventDefault();
        $.ajax({
            url: "{{ route('admin.index') }}",
            type: 'GET',
            data: {
                sectionName: sectionName,
                sectionId: idSection
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                if(data.length != 0){
                    $('.categories').empty();
                    $('.warning-block').empty();
                    for(let i = 0; i < data.length; i++){
                        let categoryName = data[i].category_name;
                        let categoryId = data[i].id;
                        $('.categories').append('<li id="li-' + categoryId + '"><a href="" onclick="categoryData(event, ' + categoryId + ')" id="category-id-' + categoryId + '">' + categoryName + '</a><i id="remove-category" class="fa fa-times" aria-hidden="true" onclick="removeCategory(event, ' + categoryId +')" title="Удалить категорию ' + categoryName + '"></i> <i title="Редактировать категорию" onclick="editElement(' + categoryId + ', 2)" class="fa fa-pencil-square-o edit-element" aria-hidden="true"></i> <i id="new-subject" class="fa fa-cube cat-id-' + categoryId + '" aria-hidden="true" onclick="appendInputSubject(' + categoryId + ')" title="Создать предмет"></i> <i class="fa fa-puzzle-piece new-attribute ctg-id-' + categoryId + '" aria-hidden="true" onclick="appendInputAttributeForCat(' + categoryId + ')" title="Создать атрибут"></i> <div id="edit-category-' + categoryId + '" class="row edit-category"></div> <ul class="atr-st row" id="attributes-row-'+ categoryId +'"></ul> </li> <ul id="cat-' + categoryId + '"></ul><hr>');
                        attributesData(event, categoryId);
                    }
                    $('.categories').append('<li><a href="" onclick="appendInputCategory(event, ' + idSection + ')">+ Добавить категорию</a></li>');
                } else{
                    $('.categories').empty();
                    $('.warning-block').empty();
                    $('.categories').append('<li class="alert alert-warning-section">Категории отсутствуют!</li><li><a href="" onclick="appendInputCategory(event, ' + idSection + ')">+ Добавить категорию</a></li>');
                }
            }
        })
    }



    function categoryData(event, categoryID){
        event.preventDefault();
        let child = $('#cat-' + categoryID).children();
        let disp = $('#cat-' + categoryID).css('display');
        if(child.length != 0 && disp == 'none'){
            $('#cat-' + categoryID).show();
        } else if(child.length != 0 && disp == 'block') {
            $('#cat-' + categoryID).hide();
        }

        $.ajax({
            url: "{{ route('admin.category_data') }}",
            type: 'GET',
            data: {
                categoryID: categoryID,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                if(data.length != 0){
                    $('#cat-' + categoryID).empty();
                    $('.warning-block').empty();
                    for(let i = 0; i < data.length; i++){
                        let subjectName = data[i].subject_name;
                        let subjectId = data[i].id;
                        $('#cat-' + categoryID).append('<li id="sb-' + subjectId + '" class=""><a href="" onclick="subjectData(event, ' + subjectId + ')" id="subject-id-' + subjectId + '">' + subjectName + '</a><i id="remove-subject" class="fa fa-times" aria-hidden="true" onclick="removeSubject(event, ' + subjectId +')" title="Удалить предмет ' + subjectName + '"></i> <i title="Редактировать предмет" onclick="editElement(' + subjectId + ', 3)" class="fa fa-pencil-square-o edit-element" aria-hidden="true"></i>  <i id="new-element" class="fa fa-sun-o" aria-hidden="true" onclick="appendInputElement(' + subjectId + ')" title="Создать элемент"></i> <i class="fa fa-puzzle-piece new-attribute sbj-id-' + subjectId + '" aria-hidden="true" onclick="appendInputAttributeForSubject(' + subjectId + ')" title="Создать атрибут"></i> <div id="edit-subject-' + subjectId + '" class="row edit-subject"></div> <ul class="element-container" id="element-container-' + subjectId + '">  </ul> <div id="new-element-' + subjectId + '" class="row new-element"></div> </li>');
                        $('#cat-' + categoryID).filter(':last');
                    }
                } else {
                    $('#cat-' + categoryID).empty();
                    $('#cat-' + categoryID).append('<li class="alert alert-warning-section">Предметы отсутствуют!</li>');
                }
            }
        })
    }

    function subjectData(event, subjectID){
        event.preventDefault();
        $.ajax({
            url: "{{ route('admin.subject_data') }}",
            type: 'GET',
            data: {
                subjectID: subjectID,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                if(data.length != 0){
                    let subj = $('#element-container-' + subjectID).children();
                    let subjDataStyle = $('#element-container-' + subjectID).children().css('display');
                    if(subj.length == 0){
                        for(let i = 0; i < data.length; i++){
                            let element_name = data[i].element_name;
                            let element_id = data[i].id;
                            let subject_id = data[i].subject_id;
                            $('#element-' + element_id).remove();

                            $('#element-container-' + subject_id).append('<li id="element-' + element_id + '">' + element_name + ' <i id="remove-element" class="fa fa-times" aria-hidden="true" onclick="removeSubjectElement(event, ' + element_id + ')" title="Удалить элемент ' + element_name + '"></i> <i title="Редактировать элемент" onclick="editElement(' + element_id + ', 4)" class="fa fa-pencil-square-o edit-element" aria-hidden="true"></i> <i id="elem-edit-id-' + element_id + '" class="fa fa-puzzle-piece new-attribute" aria-hidden="true" onclick="appendInputAttributeForElement(' + element_id + ')" title="Создать атрибут"></i> <div id="edit-element-' + element_id + '" class="row edit-element"></div> </li>');
                        }
                    } else if(subj.length != 0 && subjDataStyle == 'block'){
                        $('#element-container-' + subjectID).children().hide();
                    } else if(subj.length != 0 && subjDataStyle == 'none'){
                        $('#element-container-' + subjectID).children().show();
                    }

                } else {
                    alert('Не имеется элементов!');
                }
            }
        })
    }


    function removeSubjectElement(){

    }

    function appendInput(event){
        event.preventDefault();
        let inputSection =$('.sections').children('input');
        if(inputSection.length == 0){
            $('.sections').append('<input class="form-control" placeholder="Название Раздела" id="input-section" type="text" name="section-name"/> <a href="" class="create-button" onclick="newSection(event)">Создать</a>');
        }
    }

    function appendInputCategory(event, idSecion){
        event.preventDefault();
        let inputSection =$('.categories').children('input');
        if(inputSection.length == 0){
            $('.categories').append('<input class="form-control" placeholder="Название Категории" id="input-category" type="text" name="section-name"/><a href="" class="create-button"  onclick="newCategory(event, ' + idSecion + ')">Создать</a>');
        }
    }

    function newSection(event){
        event.preventDefault();
        let sN = $('#input-section').val();
        $.ajax({
            url: "{{ route('admin.create_section') }}",
            type: 'POST',
            data: {
                section: sN,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                updataSections()
            }
        })
    }

    let sName;
    let sId;

    function removeSectionSuccess(event){
        event.preventDefault();
        $.ajax({
            url: "{{ route('admin.remove_section') }}",
            type: 'POST',
            data: {
                section: sName,
                sectionId: sId
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                updataSections()
            }
        })
    }

    function removeSectionCancel(){
        $('.alert-warning-section').remove();
    }

    function removeSection(event, sectionName, sectionId){
        event.preventDefault();
        sName = sectionName;
        sId = sectionId;
        $('.warning-block').empty();
        $('.warning-block').prepend('<div class="alert alert-warning-section" role="alert">Раздел " ' + sectionName + ' " и все связанные с ним данные будут удалены!<button type="button" class="btn btn-success-section" onclick="removeSectionSuccess(event)">Удалить</button><button type="button" class="btn btn-warning-section" onclick="removeSectionCancel()">Отмена</button></div>');
    }

    /*---- Section ----*/



    /*---- Category ----*/

    let cName;
    let cId;

    function removeCategory(event, categoryId){
        event.preventDefault();
        let catName = $('#category-id-' + categoryId).html();
        cName = catName;
        cId = categoryId;
        $('.warning-block').empty();
        $('.warning-block').prepend('<div class="alert alert-warning-section" role="alert">Категория " ' + catName + ' " и все связанные с ней данные будут удалены!<button type="button" class="btn btn-success-section" onclick="removeCategorySuccess(event, ' + categoryId + ')">Удалить</button><button type="button" class="btn btn-warning-section" onclick="removeCategoryCancel()">Отмена</button></div>');
        $('html').scrollTop(0);
    }

    function removeCategorySuccess(event, categoryID){
        event.preventDefault();
        getSectionIdForCategory(event, categoryID);
    }

    function removeCategoryEnd(event, categoryID, sectionID){
        $.ajax({
            url: "{{ route('admin.remove_category') }}",
            type: 'POST',
            data: {
                categoryID: categoryID,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                getSectionName(event, sectionID);
            }
        })
    }


    function getSectionIdForCategory(event, categoryID){
        $.ajax({
            url: "{{ route('admin.get_section_id_for_cat') }}",
            type: 'GET',
            data: {
                categoryID: categoryID
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                let sectionID = data[0].section_id;
                removeCategoryEnd(event, categoryID, sectionID);
            }
        })
    }

    function getSectionIdForEdit(event, categoryID){
        $.ajax({
            url: "{{ route('admin.get_section_id_for_edit') }}",
            type: 'GET',
            data: {
                categoryID: categoryID
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                let sectionID = data[0].section_id;
                getSectionName(event, sectionID);
            }
        })
    }


    function removeCategoryCancel(){
        $('.alert-warning-section').remove();
    }



    function getSectionName(event, sectionID){
        $.ajax({
            url: "{{ route('admin.get_section_name') }}",
            type: 'GET',
            data: {
                sectionID: sectionID
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                let sectionName = data[0].name;
                sectionData(event, sectionName, sectionID);
            }
        })
    }



    function newCategory(event, idSection){
        event.preventDefault();
        let cat = $('#input-category').val();
        $.ajax({
            url: "{{ route('admin.create_category') }}",
            type: 'POST',
            data: {
                category: cat,
                idSection: idSection
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                getSectionName(event, idSection);
            }
        })
    }

    /*---- Category ----*/



    /*---- Subject ----*/

    function removeSubjectSuccess(event, subjectID){
        event.preventDefault();
        getCategoryId(event, subjectID);
    }

    function getCategoryIdForEdit(event, subjectID){
        let = parentEl = $('#sb-' + subjectID).parent();
        parentID = parentEl[0].id;
        parentID = parentID.replace('cat-', '');
        let categoryID = Number(parentID);
        $('#cat-' + categoryID).hide();
        categoryData(event, categoryID);
    }

    function getCategoryId(event, subjectID){
        let = parentEl = $('#sb-' + subjectID).parent();
        parentID = parentEl[0].id;
        parentID = parentID.replace('cat-', '');
        let categoryID = Number(parentID);
        
        $.ajax({
            url: "{{ route('admin.remove_subject') }}",
            type: 'POST',
            data: {
                subjectID: subjectID,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                
            }
        })

        $('#cat-' + categoryID).hide();
        categoryData(event, categoryID);
    }

    function removeSubject(event, subjectID){
        event.preventDefault();
        let subjName = $('#subject-id-' + subjectID).html();
        $('.warning-block').empty();
        $('.warning-block').prepend('<div class="alert alert-warning-section" role="alert">Предмет " ' + subjName + ' " и все связанные с ним данные будут удалены!<button type="button" class="btn btn-success-section" onclick="removeSubjectSuccess(event, ' + subjectID + ')">Удалить</button><button type="button" class="btn btn-warning-section" onclick="removeCategoryCancel()">Отмена</button></div>');
        $('html').scrollTop(0);
    }

    function appendInputSubject(categoryID){
        let inputAttr = $('.input-div-' + categoryID);
        let inputAttrDisp = $('.input-div-' + categoryID).css('display');
        let inputF = $('.input-subject').length;
        if(inputAttr.length == 0 && inputAttrDisp == undefined || inputF == 0){
            $('.form-div').remove();
            $('#li-' + categoryID).append('<div class="form-div input-div-' + categoryID + '"><form><input class="form-control input-subject" placeholder="Название Предмета" id="input-subject-'+ categoryID +'" type="text" name="section-name"/><a href="" class="create-button" onclick="newSubject(event, ' + categoryID + ')">Создать</a></form></div>');
        } else if(inputAttr.length != 0 && inputAttrDisp == 'block'){
            $('.input-div-' + categoryID).hide();
        } else if(inputAttr.length != 0 && inputAttrDisp == 'none'){
            $('.input-div-' + categoryID).show();
        }

    }

    function newSubject(event, categoryID){
        event.preventDefault();
        let subj = $('#input-subject-' + categoryID).val();
        $.ajax({
            url: "{{ route('admin.create_subject') }}",
            type: 'POST',
            data: {
                subject: subj,
                categoryID: categoryID
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                $('#cat-' + categoryID).hide();
                categoryData(event, categoryID);
            }
        })
    }

    /*---- Subject ----*/


    /*---- Element ----*/



    function newElementSuccess(event, subjectID){
        event.preventDefault();
        
        let elementName = $('#input-new-element-' + subjectID).val();
        //console.log(elementName);

        $.ajax({
            url: "{{ route('admin.create_element') }}",
            type: 'POST',
            data: {
                subjectID: subjectID,
                elementName: elementName
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                //location.reload()
            }
        })
    }

    function appendInputElement(subjectID){
        let inputElem = $('#input-new-element-' + subjectID);
        let inputElemDisp = $('#input-new-element-' + subjectID).css('display');

        if(inputElem.length == 0 && inputElemDisp == undefined){
            $('.input-new-element').next().remove();
            $('.input-new-element').remove();
            $('#new-element-' + subjectID).append('<input class="form-control input-new-element" id="input-new-element-' + subjectID + '" type="text"/><a href="" onclick="newElementSuccess(event, ' + subjectID + ')" class="create-button" >Создать элемент</a>');
        } else if(inputElem.length != 0 && inputElemDisp == 'block'){
            $('#input-new-element-' + subjectID).next().hide();
            $('#input-new-element-' + subjectID).hide();
        } else if(inputElem.length != 0 && inputElemDisp == 'none'){
            $('#input-new-element-' + subjectID).next().show();
            $('#input-new-element-' + subjectID).show();
        }
        
    }

    /*---- Element ----*/



    /*---- Attribute ----*/

    function appendInputAttributeForCat(categoryID){
        let inputAttr = $('.input-div-' + categoryID);
        let inputAttrDisp = $('.input-div-' + categoryID).css('display');
        let inputF = $('.input-attribute').length;

        if(inputAttr.length == 0 && inputAttrDisp == undefined || inputF == 0){
            $('.form-div').remove();
            $('#li-' + categoryID).append('<div class="form-div input-div-' + categoryID + '"><form id="category-form-' + categoryID + '"><input class="form-control input-attribute" placeholder="Название Атрибута" type="text" name="attribute-name"/> <input class="form-control input-attribute" placeholder="Описание Атрибута" type="text" name="description"/> <input class="form-control input-attribute" placeholder="Номинальное значение Атрибута (Целое число)" type="number" name="number-attribute"/> <input class="form-control input-attribute" placeholder="Номинальное значение Атрибута (Дробное число - точность 2 после запятой)" type="number" name="double-2"/> <input class="form-control input-attribute" placeholder="Номинальное значение Атрибута (Дробное число - точность 15 после запятой)" type="number" name="double-15"/> <span class="span-attribute">Время начала</span> <input class="form-control input-attribute" placeholder="Время" type="time" name="time-first"/> <span class="span-attribute">Время окончания</span> <input class="form-control input-attribute" placeholder="Время" type="time" name="time-second"/> <input class="form-control input-attribute" placeholder="Текст Атрибута" type="text" name="attribute-text"/> <input class="form-control input-attribute" placeholder="Строковые данные" type="text" name="attribute-varchar"/> <input class="form-control input-attribute file-input" onchange="encodeImage(this)" type="file" name="attribute-file"/> <a class="link" id="image-data-' + categoryID + '" href=""></a> <span class="span-attribute">Да</span> <input class="form-control input-attribute input-radio-attribute" type="radio" name="attribute-bool" value="true" /> <span class="span-attribute">Нет</span> <input class="form-control input-attribute input-radio-attribute" type="radio" name="attribute-bool" value="false"/> <input class="form-control input-attribute" placeholder="IP адрес" type="text" name="attribute-ip"/> <input type="submit" class="create-button"  onclick="newAttributeForCat(event, ' + categoryID + ')"/></form> <hr style="width: 25%;"></div>');
        } else if(inputAttr.length != 0 && inputAttrDisp == 'block'){
            $('.input-div-' + categoryID).hide();
        } else if(inputAttr.length != 0 && inputAttrDisp == 'none'){
            $('.input-div-' + categoryID).show();
        }
    }

    function newAttributeForCat(event, categoryID){
        event.preventDefault();
        let subj = $('#category-form-' + categoryID).children('input');
        let createAttribute = 'category';
        let imgData = $('#image-data-' + categoryID).attr('href');

        $.ajax({
            url: "{{ route('admin.create_attribute') }}",
            type: 'POST',
            data: {
                attributeName: subj[0].value,
                description: subj[1].value,
                numberAttribute: subj[2].value,
                double2: subj[3].value,
                double15: subj[4].value,
                timeFirst: subj[5].value,
                timeSecond: subj[6].value,
                attributeText: subj[7].value,
                attributeVarchar: subj[8].value,
                attributeFile: imgData,
                attributeTrue: subj[10].checked,
                attributeFalse: subj[11].checked,
                attributeIP: subj[12].value,
                createAttribute: createAttribute,
                categoryID: categoryID

            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                location.reload()
            }
        })
    }

    /*---- Attribute ----*/

    /* ---- Incode Image ----*/ 

    function encodeImage(element) {
        var file = element.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
            $(".link").attr("href",reader.result);
        }
        reader.readAsDataURL(file);
    }

    /* ---- Incode Image ----*/ 

</script>

@endsection