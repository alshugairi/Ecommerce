<template>
    <div class="card card-action mb-3">
        <div class="card-alert"></div>
        <div class="card-header">
            <div class="card-action-title fw-bold">{{ title }}</div>
            <div class="card-action-element">
                <ul class="list-inline mb-0">
                </ul>
            </div>
        </div>
        <div class="collapse show px-3 layout-section-body">
            <slot />
        </div>
    </div>
</template>

<script>
export default {
    props: {
        title: String,
    },
};
</script>
