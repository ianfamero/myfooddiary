<template>
  <div>
    <el-menu
      :router="true" :default-active="$route.path"
      class="el-menu"
      mode="horizontal">
      <el-menu-item index="/food-diary" @click="$root.moveTo('/food-diary')">Food Diary</el-menu-item>
      <el-menu-item index="/food-list" @click="$root.moveTo('/food-list')">Food List</el-menu-item>
      <el-submenu>
        <template slot="title"><i class="fa fa-2x fa-user-circle" style="color: #fff"></i></template>
        <el-menu-item index="/profile" @click="$root.moveTo('/profile')">My Profile</el-menu-item>
        <el-menu-item index="/report" @click="$root.moveTo('/report')">Reports</el-menu-item>
        <el-menu-item @click="$root.linkTo('/logout')" style="color: red">Logout</el-menu-item>
      </el-submenu>
    </el-menu>
  </div>
</template>

<script>
  export default {

  }
</script>
