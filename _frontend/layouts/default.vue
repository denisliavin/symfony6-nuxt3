<template>
    <div>
        <LayoutHeader/>
        <slot></slot>
        <LayoutFooter/>
    </div>
</template>
<script setup>
const cookieKey = useCookie('key')
if (!cookieKey.value) {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < 222; i++) {
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    cookieKey.value = text
}
</script>
