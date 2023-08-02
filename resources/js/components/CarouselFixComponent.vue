<template>
  <div></div>
</template>

<script>
export default {
  setup() {
    return {};
  },
};
</script>

<style lang="scss">
.carousel__pagination-button::after {
  background-color: #585858;
  width: 10px;
  height: 10px;
  border-radius: 50%;
}
.carousel__pagination-button:hover::after,
.carousel__pagination-button--active::after {
  background-color: #af3131;
}
</style>