import * as React from 'react';
import { WebView } from 'react-native-webview';
import { StyleSheet, StatusBar } from 'react-native';
import Constants from 'expo-constants';

export default function App() {
  return (
    <>
    <StatusBar backgroundColor="#212529" barStyle="light-content" />
    <WebView
      source={{ uri: 'https://myriad.hxrsh.tech' }}
    />
    </>
  );
}
