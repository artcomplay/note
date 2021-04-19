<template>
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
</template>

<script>
    export default {
        mounted() {
            console.log('4')
        }
    }
</script>