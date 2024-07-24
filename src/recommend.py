import pandas as pd
from sklearn.metrics.pairwise import cosine_similarity

def generate_recommendations(user_id):
    # Fetch user-deal interaction data
    interactions = pd.read_sql("SELECT user_id, deal_id, interaction_score FROM user_deal_interactions", get_db_connection())
    
    # Create a user-deal matrix
    user_deal_matrix = interactions.pivot(index='user_id', columns='deal_id', values='interaction_score').fillna(0)
    
    # Calculate cosine similarity between users
    user_similarity = cosine_similarity(user_deal_matrix)
    
    # Find similar users
    similar_users = user_similarity[user_id].argsort()[::-1][1:6]  # Top 5 similar users
    
    # Get deals liked by similar users
    recommended_deals = interactions[interactions['user_id'].isin(similar_users) & (interactions['interaction_score'] > 3)]['deal_id'].unique()
    
    return recommended_deals