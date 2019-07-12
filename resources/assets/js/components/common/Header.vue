<template>
  <div>
    <el-menu
      :router="true" :default-active="$route.path"
      class="el-menu"
      mode="horizontal">
      <el-menu-item index="/food-diary" @click="$root.moveTo('/food-diary')">FOOD DIARY</el-menu-item>
      <el-menu-item index="/food-list" @click="$root.moveTo('/food-list')">FOOD LIST</el-menu-item>
      <el-submenu>
        <template slot="title"><i class="fa fa-2x fa-user-circle" style="color: #fff"></i></template>
        <el-menu-item index="/profile" @click="$root.moveTo('/profile')">PROFILE</el-menu-item>
        <el-menu-item @click="$root.linkTo('/logout')">LOGOUT</el-menu-item>
      </el-submenu>
      <!-- <el-menu-item index="/logout" @click="$root.linkTo('/logout')" style="background: #FBCFD0; color: red">LOGOUT</el-menu-item> -->
    </el-menu>
  </div>
</template>

<script>
  export default {

  }
</script>
