<template>
  <div class="card">
    <div class="card-body bg-dark">
      <p class="col-md-10 text-white"> {{ title }} </p>
      <slot />
    </div>
  </div>
</template>

<script>
export default {
  name: 'Card',

  props: {
    title: { type: String, default: null }
  }
}
</script>
