/*
スタート、ストップ、リセットができるタイマーを作成
*/
// @flow
import React from 'react';

type Props = {
}

type State = {
  time: number,
  isRunning: bool,
  disabledStart: bool,
  disabledStop: bool,
}

class Timer extends React.Component<Props, State> {
  timerId: IntervalID;

  constructor(props: Props): void {
    super(props);
    this.state = {
      time: 0,
      isRunning: false,
      disabledStart: false,
      disabledStop: true,
    };
  }

  componentWillUnmount(): void {
    this.stop();
  }

  start(): void {
    if (this.state.isRunning) {
      return;
    }
    this.timerId = setInterval(() => this.tick(), 1000);
    this.setState({
      isRunning: true,
      disabledStart: true,
      disabledStop: false,
    });
  }

  stop(): void {
    clearInterval(this.timerId);
    this.setState({
      isRunning: false,
      disabledStart: false,
      disabledStop: true,
    });
  }

  reset(): void {
    this.stop();
    this.setState({time: 0});
  }

  tick(): void {
    this.setState((prevState) => {
      return {time: prevState.time + 1};
    });
  }

  formatTime(second: number): string {
    const s = second % 60;
    const m = parseInt(second / 60, 10);
    const h = parseInt(m / 60, 10)
    return `${h}:${m}:${s}`;
  }

  render() {
    return (
      <div class='timer'>
        {this.formatTime(this.state.time)}
        <StartButton onClick={() => this.start()} disabled={this.state.disabledStart}/>
        <StopButton onClick={() => this.stop()} disabled={this.state.disabledStop}/>
        <ResetButton onClick={() => this.reset()} />
      </div>
    );
  }
}

type ButtonProp = {
  onClick: () => void,
  disabled?: bool,
}

function StartButton(props: ButtonProp) {
  return (
    <button className="button start" onClick={props.onClick} disabled={props.disabled}>
      Start
    </button>
  );
}

function StopButton(props: ButtonProp) {
  return (
    <button className="button start" onClick={props.onClick} disabled={props.disabled}>
      Stop
    </button>
  );
}

function ResetButton(props: ButtonProp) {
  return (
    <button className="button start" onClick={props.onClick} disabled={props.disabled}>
      Reset
    </button>
  );
}

export default Timer;
