<template>
    <div class="search">
        <input type="search" placeholder="Поиск друзей">
    </div>
    <div class="block">
        Тут будут друзья
    </div>
</template>

<script>
export default {

}
</script>

<style lang="scss" scoped>
.search {
    margin-top: 20px;

    input {
        width: 100%;
        height: 40px;
        background: transparent;
        border: 2px solid #af3131;
        border-radius: 10px;
        padding-left: 5px;
    }
}
</style>