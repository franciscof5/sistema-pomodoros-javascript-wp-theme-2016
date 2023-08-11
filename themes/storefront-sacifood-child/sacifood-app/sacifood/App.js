import * as React from 'react';
import { Text, View, StyleSheet, ScrollView } from 'react-native';
import Constants from 'expo-constants';

// You can import from local files
import AssetExample from './components/AssetExample';

// or any pure javascript modules available in npm
import { Card } from 'react-native-paper';

export default class App extends React.Component {
  render() {
    return (
      <ScrollView style={styles.container}>
        <Text style={styles.paragraph}>
          Saci Food - Delícias congeladas.
        </Text>
        <Text style={styles.subtext}>Em breve no ar</Text>
        <Card>
          <AssetExample />
        </Card>
      </ScrollView>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    paddingTop: Constants.statusBarHeight,
    backgroundColor: '#ecf0f1',
    padding: 8,
  },
  paragraph: {
    marginTop: 28,
    margin: 14,
    fontSize: 18,
    fontWeight: 'bold',
    textAlign: 'center',
  },
  subtext: {
    textAlign: 'center',
    margin: 12,
  },
});
