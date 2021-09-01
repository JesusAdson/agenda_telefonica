<template>
    <div :class="estilo" role="alert">
        {{titulo}}
        <hr>
        <span v-if="message">{{message}}</span>
    </div>
</template>

<script>
    export default{
        props: ['tipo', 'message','titulo'],
        computed: {
            estilo(){
                return 'alert alert-'+this.tipo
            }
        },

    }
</script>