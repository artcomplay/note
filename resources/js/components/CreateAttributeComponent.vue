<template>
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
</template>

<script>
    export default {
        mounted() {
            console.log('0')
        }
    }
</script>