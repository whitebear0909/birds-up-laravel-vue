<template>
  <div class="app-welcome">
      <h1 class="col-md-12 text-center text-white py-3">CONTACTS</h1>
      <div class="d-flex justify-content-center flex-wrap">
        <div class="col-md-5 col-sm-12 col-12 mb-3">
          <h2 class="text-white">Getting in touch is easy!</h2>
          <h4 class="text-white">Welcome to Birdsup</h4>
          <a class="text-white">www.birdsup.com</a>
        </div>
        <div class="col-md-5 col-sm-12 col-12">
          <form>
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Your Name">
            </div>
            <div class="form-group">
              <input type="email" class="form-control" aria-describedby="emailHelp" placeholder="Your Email">
            </div>
            <div class="form-group">
                <textarea class="form-control" rows="4" placeholder="Write us something here...."></textarea>
            </div>
            <button type="submit" class="btn btn-custom1 text-white float-right">Submit</button>
          </form>
        </div>
      </div>      
  </div>
</template>

<script>

export default {
  
}
</script>

<style scoped lang="scss">
  a {
    cursor: pointer;
  }
</style>
