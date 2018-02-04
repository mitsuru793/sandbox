/*
タイマーのスタートボタンをトグルにする。
*/
import React from 'react';
type Props = {
}

type State = {
  time: number,
  isRunning: bool,
  disabledStop: bool,
}

class Timer extends React.Component<Props, State> {
  timerId: IntervalID;

  constructor(props: Props): void {
    super(props);
    this.state = {
      time: 0,
      isRunning: false,
      disabledStop: true,
    };
  }

  componentWillUnmount(): void {
    this.stop();
  }

  toggle(): void {
    if (this.state.isRunning) {
      this.stop();
    } else {
      this.start();
    }
  }

  start(): void {
    if (this.state.isRunning) {
      return;
    }
    this.timerId = setInterval(() => this.tick(), 1000);
    this.setState({
      disabledStop: false,
      isRunning: true,
    });
  }

  stop(): void {
    clearInterval(this.timerId);
    this.setState({
      disabledStop: true,
      isRunning: false,
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
        <ToggleButton onClick={() => this.toggle()} isRunning={this.state.isRunning} />
        <ResetButton onClick={() => this.reset()} />
      </div>
    );
  }
}

type ToggleButtonProp = {
  onClick: () => void,
  isRunning: bool,
}

function ToggleButton(props: ToggleButtonProp) {
  const text = props.isRunning ? 'Stop' : 'Start';
  return (
    <button className="button toggle" onClick={props.onClick}>
      {text}
    </button>
  );
}

type ResetButtonProp = {
  onClick: () => void,
}

function ResetButton(props: ResetButtonProp) {
  return (
    <button className="button start" onClick={props.onClick}>
      Reset
    </button>
  );
}

export default Timer;
