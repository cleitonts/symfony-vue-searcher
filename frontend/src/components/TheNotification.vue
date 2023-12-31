<template>
  <div v-show="snackbar" class="notification" :class="type">
    {{ text }}
    <button @click="closeSnackbar">&times;</button>
  </div>
</template>

<script>
import { ref, onMounted, watch } from "vue";
import {
  EMessageType,
  useNotificationStore,
} from "@/stores/notificationStore.js";

export default {
  name: "TheNotification",
  props: {
    text: {
      type: String,
      required: true,
    },
    title: {
      type: String,
      default: "",
    },
    lastId: {
      type: Number,
      required: true,
    },
    type: {
      type: String,
      default: "info",
      validator: (value) => {
        const acceptedValues = Object.values(EMessageType);
        return acceptedValues.indexOf(value) !== -1;
      },
    },
    timeout: {
      type: Number,
      default: 5000,
    },
  },
  setup(props) {
    const snackbar = ref(true);

    const { removeMessage } = useNotificationStore();

    const closeSnackbar = () => {
      snackbar.value = false;
      removeMessage(props.lastId);
    };

    watch(
      () => snackbar.value,
      (newValue) => {
        if (!newValue) {
          removeMessage(props.lastId);
        }
      }
    );

    onMounted(() => {
      setTimeout(() => {
        closeSnackbar();
      }, props.timeout);
    });

    return {
      snackbar,
      closeSnackbar,
    };
  },
};
</script>

<style>
.notification {
  position: fixed;
  bottom: 0;
  right: 0;
  margin: 20px;
  padding: 15px;
  border-radius: 4px;
  background-color: #333;
  color: #fff;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.notification.error {
  background-color: #d9534f;
}

.notification.success {
  background-color: #5bc0de;
}

.notification.warning {
  background-color: #f0ad4e;
}

.notification.info {
  background-color: #5bc0de;
}

.notification button {
  background: none;
  border: none;
  color: inherit;
  font-size: 18px;
  cursor: pointer;
}
</style>
