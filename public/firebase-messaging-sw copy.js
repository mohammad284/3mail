importScripts('https://www.gstatic.com/firebasejs/3.9.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/3.9.0/firebase-messaging.js');

// Initialize the Firebase app in the service worker by passing in the
// messagingSenderId.
firebase.initializeApp({
  apiKey: "AIzaSyDyQcjKdCMTqMDMCHylaU20WgZ0eniXpGs",
  authDomain: "mohammadhussen-edea9.firebaseapp.com",
  projectId: "mohammadhussen-edea9",
  storageBucket: "mohammadhussen-edea9.appspot.com",
  messagingSenderId: "111711610488",
  appId: "1:111711610488:web:ff4876aaa5c1ad9df0ef8d",
  measurementId: "G-302VKD9JBH"

});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  // Customize notification here
  const notificationTitle = 'Background Message Title';
  const notificationOptions = {
    body: 'Background Message body.',
    icon: 'https://images.theconversation.com/files/93616/original/image-20150902-6700-t2axrz.jpg' //your logo here
  };

  return self.registration.showNotification(notificationTitle,
      notificationOptions);
});