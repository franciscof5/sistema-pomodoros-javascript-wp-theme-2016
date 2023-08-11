import * as React from 'react';
import { Text, View, StyleSheet, Image, ScrollView } from 'react-native';

export default class AssetExample extends React.Component {
  render() {
    return (
      <ScrollView style={styles.container}>
        <Text style={styles.paragraph}>
         Marmitas
        </Text>
        <Image style={styles.logo} source={require('../assets/strogonoff.png')} />
        <Text style={styles.paragraph}>
         Sobremesas
        </Text>
        <Image style={styles.logo} source={require('../assets/sorvete.png')} />
      </ScrollView>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    alignItems: 'center',
    justifyContent: 'center',
    padding: 4,
  },
  paragraph: {
    margin: 4,
    fontSize: 14,
    fontWeight: 'bold',
    textAlign: 'center',
  },
  logo: {
    height: 200,
    width: 300,
  }
});
