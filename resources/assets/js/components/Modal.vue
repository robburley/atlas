<template>
    <transition name="modal">
        <div class="vue-modal-mask">
            <div class="vue-modal-wrapper">
                <div class="vue-modal-container">
                    <div class="vue-modal-header text-left">
                        <h4 class="modal-title">
                            <slot name="header"></slot>
                            <a class="pull-right" @click.prevent="$emit('close')">
                                <i class="fa fa-close"></i>
                            </a>
                        </h4>
                    </div>

                    <div class="vue-modal-body">
                        <slot name="body"></slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {}
</script>
