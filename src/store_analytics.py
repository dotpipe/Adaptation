import dash
import dash_core_components as dcc
import dash_html_components as html
from dash.dependencies import Input, Output
import plotly.express as px

app = dash.Dash(__name__)

app.layout = html.Div([
    dcc.Dropdown(id='store-dropdown', options=[{'label': i, 'value': i} for i in get_all_stores()], value='Store A'),
    dcc.Graph(id='view-trend'),
    dcc.Graph(id='engagement-rate')
])

@app.callback(
    [Output('view-trend', 'figure'),
     Output('engagement-rate', 'figure')],
    [Input('store-dropdown', 'value')]
)
def update_graphs(selected_store):
    conn = get_db_connection()
    df = pd.read_sql(f"SELECT DATE(timestamp) as date, COUNT(*) as views, SUM(clicked) as clicks FROM ad_interactions WHERE store_name = '{selected_store}' GROUP BY DATE(timestamp)", conn)
    
    view_trend = px.line(df, x='date', y='views', title='Daily Ad Views')
    engagement_rate = px.line(df, x='date', y=df['clicks']/df['views'], title='Daily Engagement Rate')
    
    return view_trend, engagement_rate

if __name__ == '__main__':
    app.run_server(debug=True)