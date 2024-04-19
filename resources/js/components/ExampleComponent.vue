<!-- resources/js/components/ExampleComponent.vue -->
<template>
    <div>
        <h1>Hello from Vue.js!</h1>
        <p>{{ message }}</p>
    </div>
</template>

<script>
export default {
    data() {
        return {
            message: 'This message is from Vue component!'
        };
    }
}
</script>
