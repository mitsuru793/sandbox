/*
インクリメンタルサーチを作る

thanks https://github.com/ahfarmer/emoji-search
*/
// @flow
import React from 'react';

type SearchState = {
  filteredWords: string[],
}

class Search extends React.Component<{}, SearchState> {
  constructor(props: SearchState) {
    super(props);
    this.state = {
      filteredWords: filterWord(''),
    }
  }

  handleSearchChange(event: SyntheticInputEvent<HTMLInputElement>) {
    this.setState({
      filteredWords: filterWord(event.target.value),
    });
  }

  render() {
    return (
      <div>
        <SearchInput textChange={(e) => this.handleSearchChange(e)}/>
        <WordResults filteredWords={this.state.filteredWords}/>
      </div>
    );
  }
}

function SearchInput(props: {textChange: SyntheticInputEvent<HTMLInputElement> => void}) {
  return (
    <div className='search-input'>
      <input onChange={props.textChange}/>
    </div>
  );
}

function WordResults(props: {filteredWords: string[]}) {
  return (
    <div className='word-results'>
      {props.filteredWords.map((word, i) => (<WordResultRow key={i} word={word}/>))}
    </div>
  );
}

function WordResultRow(props: {word: string}) {
  return (
    <div className='word-result-row'>
      <span className='word'>{props.word}</span>
    </div>
  );
}

const words = [
  'Hello World',
  'Hello, Mike',
  'Hi, Mike',
  'Good morining!',
];

function filterWord(searchWord: string): string[] {
  return words.filter((word) => {
    return word.toLowerCase().includes(searchWord);
  }).slice();
}

export default Search;
