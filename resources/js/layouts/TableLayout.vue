<template>
  <div class="container-fluid g-0 py-5">
    <div class="row">
      <div class="col">
        <div class="container">
          <div class="row mb-3 mb-md-4">
            <div class="col g-0">
              <h1 class="fs-1 fw-semibold">
                <slot name="title">Tabuľka</slot>
              </h1>
            </div>
          </div>
          <div class="row gap-2 g-0">
            <slot name="filter"></slot>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col g-0">
        <div class="table-responsive mt-3">
          <div class="table-container gx-3">
            <div class="card">
              <slot name="table" class="table mb-0"></slot>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
