<template>
    <div>
        <Graph />
    </div>
</template>

<script>
    import Graph from './Graph'

    export default {
        components: {
            Graph
        },

        mounted() {
            this.update();
        },
        methods: {

        }
    }
</script>

<style scoped>

</style>
