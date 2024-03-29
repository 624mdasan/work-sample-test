# work-sample-test

# 前提
あなたは動物園のチケット販売オペレーター用金額計算プログラム作成を依頼されました。

仕様は以下とします。
- チケットの種類は以下とする。
  - 入園チケット
  - どちらのタイプを適用するかは窓口で確認してオペレータが適切は個別にプログラムのパラメータとして指定をする。(チラシ等を持ってきたら割引的な扱いと想定してください)
 
| タイプ |  大人 | 子供 | シニア |
| -------- | -------- | -------- | -------- |
| 通常  |  1000  | 500  | 800     |
| 特別  |  600    | 400     | 500     |


- 以下の条件のときに料金を変動させる。(特別タイプのチケットでも同様の条件で料金変動させること)
  - 団体割引 10人以上だと10%割引(子供は0.5人換算とする)
  - 夕方料金 夕方17時以降は100円引きとする。
  - 休日料金 休日は200円増とする。
  - 月水割引 月曜と水曜は100円引きとする。
- 発生しうるエラーパターンについても十分考慮して適切に制御すること。
- オペレータはPCのターミナルより該当プログラムの実行をする。
- 出力結果には、最低限以下を表示すること。
  - 販売合計金額
  - 金額変更前合計金額
  - 金額変更明細

# 問題1.
- 上記仕様に沿ったプログラムを作成してください。

## 補足
- rubyもしくはphpで作成したCLIプログラムとしてください。
- DBやフレームワークの利用は不可とします。
- 仕様上の疑問点や、不明点は質問として整理した上で、想定される回答を用意して作成を進めてください。
- 【可能であれば】今後チケットの種類や割引の種類の追加変更が発生する可能性があります。その際の改修しやすさについても十分検討してください。

## 期待する成果物
- プログラム本体
- テスト結果
- 仕様に対する質問内容と想定回答(あれば)
