<template>
  <div>
    <el-menu
      default-active="1"
      class="el-menu"
      mode="horizontal">
      <el-menu-item index="1" @click="$root.moveTo('/food-diary')">FOOD DIARY</el-menu-item>
      <el-menu-item index="2" @click="$root.moveTo('/food-list')">FOOD LIST</el-menu-item>
      <el-menu-item index="3" @click="$root.moveTo('/profile')">PROFILE</el-menu-item>
    </el-menu>
  </div>
</template>

<script>
  export default {
    data() {
      return {

      }
    },
    methods: {
      
    }
  }
</script>
