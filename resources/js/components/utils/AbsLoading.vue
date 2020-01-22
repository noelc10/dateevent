<template>
  <div class="abs-loading">
    <v-progress-circular
      indeterminate
      color="dark"
    />
  </div>
</template>

<script>
export default {

}
</script>

<style scoped>
  .abs-loading {
    position: absolute;
    top: 0;
    bottom: 0;
    right: 0;
    left: 0;
    background-color: #eeeeee;
    opacity: 0.5;
    z-index: 3;
    display: flex;
    align-items: center;
    justify-content: center;
  }
</style>
