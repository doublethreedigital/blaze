<template>
  <modal
    v-if="open"
    name="blaze"
    width="510"
    height="auto"
    :adaptive="true"
    :pivotY="0.1"
    v-on-clickaway="close"
    @closed="close"
  >
    <div class="bg-grey-20 border-b text-center">
      <input
        id="blaze-input"
        type="text"
        class="p-2 text-lg w-full bg-transparent focus:outline-none"
        v-model="query"
        placeholder="Looking for something?"
        autofocus
      />
    </div>

    <ul
      v-if="results.length"
      id="blaze-result-list"
      class="flex flex-col max-h-screen-1/2 overflow-y-scroll"
    >
      <a
        v-for="result in results"
        :key="result.url"
        class="p-2 focus:bg-grey-30 focus:outline-none text-grey-80 hover:text-grey-80 focus:text-grey-80 w-full flex flex-col"
        :href="result.url"
        :target="result.target"
      >
        <span
          class="font-medium flex items-center"
          style="letter-spacing: -0.01em;"
          tabindex="-1"
        >
          <span
            v-if="result.icon"
            v-html="result.icon"
            :title="result.title"
            class="mr-1 w-4"
          ></span>

          <span v-text="result.title"></span>
        </span>

        <a
          v-if="result.parent"
          class="text-xs text-grey-70 hover:text-blue focus:outline-none"
          :href="result.parent.url"
          tabindex="-1"
        >
          {{ result.parent.title }}
        </a>
      </a>
    </ul>

    <div v-if="dump" class="max-h-screen-1/2 overflow-y-scroll">
      <div v-html="dump"></div>
    </div>
  </modal>
</template>

<script>
import axios from "axios";
import { mixin as clickaway } from "vue-clickaway";

export default {
  name: "blaze",

  mixins: [clickaway],

  data() {
    return {
      open: false,
      query: null,
      results: [],
      dump: null,
      config: null,
      focusIndex: null,
    };
  },

  mounted() {
    this.getConfig();
  },

  methods: {
    getConfig() {
      axios
        .get(cp_url("blaze/config"))
        .then((response) => {
          this.config = response.data;

          this.addHeaderButton();
          this.setupKeybindings();
        })
        .catch((error) => {
          this.$toast.error("Blaze failed to get config");
        });
    },

    addHeaderButton() {
      let headerLinks = document.querySelector(".head-link");

      let headerLink = document.createElement("button");
      headerLink.id = "blaze-header-button";
      headerLink.className =
        "hidden md:block h-8 w-8 p-sm text-grey ml-2 mr-1 hover:text-grey-80 has-tooltip";
      headerLink.setAttribute("type", "button");
      headerLink.innerHTML = `<svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 193">
  <path fill-rule="evenodd" clip-rule="evenodd" d="m98.637 19.5-2.533 5.418c2.533-5.419 2.535-5.418 2.538-5.416l.007.003.016.008.05.023.157.076c.13.063.314.153.545.269.462.232 1.117.57 1.938 1.016 1.642.89 3.951 2.214 6.706 3.985 5.499 3.535 12.828 8.888 20.171 16.184 14.69 14.594 29.679 37.239 29.679 68.679 0 35.653-27.403 64.707-61.807 64.707-34.405 0-61.808-29.054-61.808-64.707 0-17.81 6.531-32.167 12.937-41.97a85.394 85.394 0 0 1 8.85-11.347 66.453 66.453 0 0 1 2.982-3.019 42.764 42.764 0 0 1 1.222-1.112l.028-.024.01-.008.004-.004c.002-.002.004-.003 3.874 4.557l-3.87-4.56a5.982 5.982 0 0 1 9.851 4.56c0 12.337.056 21.29 1.764 27.267.806 2.82 1.817 4.318 2.813 5.148.916.764 2.437 1.48 5.392 1.48 2.955 0 5.21-1.423 7.188-5.567 2.112-4.425 3.305-10.97 3.79-18.732.477-7.632.242-15.836-.129-23.253-.118-2.368-.254-4.705-.384-6.923-.262-4.503-.496-8.52-.496-11.32a5.981 5.981 0 0 1 8.515-5.419ZM58.435 72.556a74.438 74.438 0 0 0-1.188 1.762C51.69 82.823 46.26 94.928 46.26 109.745c0 29.598 22.585 52.745 49.845 52.745 27.259 0 49.844-23.147 49.844-52.745 0-27.287-12.924-47.056-26.147-60.193-6.191-6.15-12.394-10.787-17.236-13.974.124 2.137.259 4.472.385 6.985.377 7.537.64 16.28.12 24.598-.512 8.188-1.811 16.597-4.933 23.138-3.255 6.821-8.975 12.377-17.984 12.377-5.02 0-9.48-1.278-13.05-4.253-3.49-2.907-5.47-6.893-6.657-11.051-1.205-4.217-1.758-9.274-2.011-14.815Z" fill="currentColor"/>
  <path fill-rule="evenodd" clip-rule="evenodd" d="m98.637 19.5-2.533 5.418c2.533-5.419 2.535-5.417 2.538-5.416l.007.003.016.008.05.023a29.538 29.538 0 0 1 .702.345c.462.232 1.117.57 1.938 1.016 1.642.89 3.951 2.215 6.706 3.985 5.499 3.535 12.828 8.888 20.171 16.184 14.69 14.594 29.679 37.239 29.679 68.679a5.981 5.981 0 0 1-11.963 0c0-27.287-12.924-47.056-26.147-60.193-6.191-6.15-12.394-10.787-17.236-13.974.124 2.137.259 4.472.385 6.985.377 7.537.64 16.28.12 24.598-.512 8.188-1.811 16.597-4.933 23.138-3.255 6.821-8.975 12.377-17.984 12.377a5.982 5.982 0 0 1 0-11.963c2.955 0 5.21-1.423 7.188-5.567 2.112-4.425 3.305-10.97 3.79-18.732.477-7.632.242-15.836-.129-23.253-.118-2.368-.254-4.705-.384-6.923-.262-4.503-.496-8.52-.496-11.32a5.981 5.981 0 0 1 8.515-5.419Z" fill="currentColor"/>
</svg>`;

      headerLinks.prepend(headerLink);

      document
        .getElementById("blaze-header-button")
        .addEventListener("click", () => {
          this.open = true;
          this.query = null;
        });
    },

    setupKeybindings() {
      document.addEventListener("keydown", (event) => {
        // CMD + P
        if (
          event.metaKey &&
          event.key == this.config.config.keyboard_shortcut.toLowerCase()
        ) {
          event.preventDefault();

          this.open = !this.open;
          this.query = null;
        }

        // Escape
        if (this.open && event.code === "Escape") {
          this.open = false;
        }

        // Down arrow
        if (this.open && event.code === "ArrowDown") {
          event.preventDefault();

          const results = document.getElementById("blaze-result-list")
            ?.children;

          if (results && this.focusIndex + 1 > results.length - 1) {
            return;
          }

          if (this.focusIndex == null) {
            results[0].focus();

            this.focusIndex = 0;

            return;
          }

          results[this.focusIndex + 1].focus();

          this.focusIndex = this.focusIndex + 1;
        }

        // Up arrow
        if (this.open && event.code === "ArrowUp") {
          event.preventDefault();

          const results = document.getElementById("blaze-result-list")
            ?.children;

          if (results && this.focusIndex - 1 < 0) {
            return;
          }

          results[this.focusIndex - 1].focus();

          this.focusIndex = this.focusIndex - 1;
        }
      });
    },

    getResults() {
      this.focusIndex = null;

      if (!this.query) {
        this.results = [];
      }

      axios
        .post(cp_url("blaze"), {
          query: this.query,
        })
        .then((response) => {
          if (typeof response.data === "string") {
            this.results = [];
            this.dump = response.data;

            return;
          }

          this.results = response.data;
          this.dump = null;
        })
        .catch((error) => {
          this.results = [];
          this.dump = null;
        });
    },

    close() {
      this.open = false;
    },
  },

  watch: {
    open(value) {
      if (value === true) {
        let openInputTimer = setInterval(() => {
          if (document.getElementById("blaze-input")) {
            document.getElementById("blaze-input").autofocus;
            document.getElementById("blaze-input").focus();

            clearInterval(openInputTimer);
          }
        }, 100);
      }
    },

    query(value) {
      this.getResults();
    },
  },
};
</script>

<style>
/* Please don't hunt me down and tell me off, this is GOOD css btw. Thanks and goodbye. */

[data-modal="blaze"] .v--modal-box {
  top: 79px !important;
}
</style>
